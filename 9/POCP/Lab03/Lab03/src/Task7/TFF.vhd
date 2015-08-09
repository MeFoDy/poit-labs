library IEEE;
use IEEE.STD_LOGIC_1164.ALL; 

entity TFF is
	port (
		clr, t, c : in std_logic;
		q: out std_logic
		);
end TFF;

architecture Behavioral of TFF is
	signal t_q, tx: std_logic;
begin
	tx <= t_q xor T;
	
	process (CLR, C, tx)
	begin
		if CLR = '1' then
			t_q <= '0';
		elsif rising_edge(C) then
			t_q <= tx;
		end if;
	end process;
	
	Q <= t_q;
	
end Behavioral;

