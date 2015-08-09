library IEEE;
use IEEE.STD_LOGIC_1164.ALL;

entity RSFF is
	port( 
		S,R,clock: in std_logic;
		Q, nQ: out std_logic);
end RSFF;

architecture Behavioral of RSFF is
	signal t_q: std_logic;
begin
	process(clock)
	begin
		if (rising_edge(clock)) then
			if(S = '1' and R = '1')then
				t_q <= 'Z';
			elsif(S = '0' and R = '1')then
				t_q <= '0';
			elsif (S = '1' and R = '0')	then
				t_q <= '1';
			end if;
		end if;
	end process;
	
	Q <= t_q;
	nQ <= not t_q;
	
end Behavioral;