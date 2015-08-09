library IEEE;
use IEEE.STD_LOGIC_1164.ALL;

entity JKFF is
	port( 
		J,K,clock: in std_logic;
		Q, nQ: out std_logic);
end JKFF;

architecture Behavioral of JKFF is
	signal t_q, t_inv: std_logic;
begin
	t_inv <= t_q;
	
	process(clock, t_inv)
	begin
		if (rising_edge(clock)) then
			if(J = '1' and K = '1')then
				t_q <= t_inv;
			elsif(J = '0' and K = '1')then
				t_q <= '0';
			elsif (J = '1' and K = '0')	then
				t_q <= '1';
			end if;
		end if;
	end process;
	
	Q <= t_q;
	nQ <= not t_q;
	
end Behavioral;