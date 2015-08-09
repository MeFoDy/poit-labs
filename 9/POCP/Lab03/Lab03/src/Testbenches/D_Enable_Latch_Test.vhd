library ieee;
use     ieee.std_logic_1164.all;
use     ieee.std_logic_unsigned.all;
use 	std.textio.all;

entity D_Enable_Latch_Test is
end    D_Enable_Latch_Test;

architecture Beh of D_Enable_Latch_Test is
    component D_Enable_Latch
        port(
            D, E: in  std_logic;
            Q, nQ: out std_logic
            );
    end component;
    
    signal stimuli: std_logic_vector(1 downto 0) := (others => '0');
    
    signal response_struct, response_struct_q, response_beh, response_beh_q: std_logic;
    
    signal d_enable_latch_q, d_enable_latch_q1, d_enable_latch_beh_q, d_enable_latch_beh_q1: std_logic;
    
    signal sampled_response_struct, sampled_response_struct_q, sampled_response_beh, sampled_response_beh_q: std_logic;
    
    signal error: std_logic;
    
    constant min_time_between_events: time := 10 ns;
    constant sampling_period:         time := min_time_between_events / 2;
begin
	stimuli_generation: process
	variable buf : LINE;
    begin
        while(stimuli /= (stimuli'range => '1')) loop
            wait for min_time_between_events;
            
            stimuli <= stimuli + 1;
        end loop;
        
		write(buf, "The operation has been completed successfully.");
		writeline(output, buf);
        
        wait;
    end process;
	
    D_Enable_Latch_Struct: entity D_Enable_Latch(Struct) port map(
		D => stimuli (1),
		E => stimuli (0),
        Q => response_struct,
		nQ => response_struct_q
        );
    
    D_Enable_Latch_Beh:  entity D_Enable_Latch(Beh) port map(
        D => stimuli (1),
		E => stimuli (0),
        Q => response_beh,
		nQ => response_beh_q
        );
		
    d_enable_latch_q <= response_struct;
    d_enable_latch_beh_q  <= response_beh;	
	d_enable_latch_q1 <= response_struct_q;
    d_enable_latch_beh_q1  <= response_beh_q;
    
    sampled_response_struct <= response_struct after sampling_period;
    sampled_response_beh  <= response_beh  after sampling_period;
	sampled_response_struct_q <= response_struct_q after sampling_period;
    sampled_response_beh_q  <= response_beh_q  after sampling_period;
    
    error <= (sampled_response_struct xor sampled_response_beh) and (sampled_response_struct_q xor sampled_response_beh_q);
    
    assert error /= '1' report "The device doesn't work as expected." severity failure;
end Beh;
