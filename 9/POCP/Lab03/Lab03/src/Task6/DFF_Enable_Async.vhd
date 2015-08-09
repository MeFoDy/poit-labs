LIBRARY IEEE;
USE IEEE.STD_LOGIC_1164.ALL;

entity DFF_Enable_Async is port (
		Clock: in std_logic;
		Enable: in std_logic;
		Set: in std_logic;
		Clear: in std_logic;
		D: in std_logic;
		Q, nQ: out std_logic);
end DFF_Enable_Async;

architecture Behavioral of DFF_Enable_Async is
	signal t_q: std_logic;
begin
	process (Clock, Set, Clear)
	begin
		if (Set = '1') then
			t_q <= '1';
		elsif (Clear = '1') then
			t_q <= '0';
		elsif (Clock'event and Clock = '1') then
			if Enable = '1' then
				t_q <= D;
			end if;
		end if;
	end process;
	
	Q <= t_q;
	nQ <= not t_q;
	
end Behavioral;