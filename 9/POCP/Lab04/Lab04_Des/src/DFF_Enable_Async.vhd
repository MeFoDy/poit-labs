LIBRARY IEEE;
USE IEEE.STD_LOGIC_1164.ALL;

entity DFF_Enable_Async is port (
		Clock: in std_logic;
		Enable: in std_logic;
		Clear: in std_logic;
		D: in std_logic;
		Q: out std_logic);
end DFF_Enable_Async;

architecture Behavioral of DFF_Enable_Async is
	signal t_q: std_logic;
begin
	process (Clock, Clear)
	begin
		if (Clear = '1') then
			t_q <= '0';
		elsif (Clock'event and Clock = '1') then
			if Enable = '1' then
				t_q <= D;
			end if;
		end if;
	end process;
	
	Q <= t_q;
	
end Behavioral;