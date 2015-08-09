library IEEE;
use IEEE.STD_LOGIC_1164.ALL;

entity DFF is port (
		D, Clock: in STD_LOGIC;
		Q: out STD_LOGIC);
end DFF;

architecture Behavior of DFF is
begin
	process(Clock)
	begin
		if (Clock'Event and Clock = '1') then
			Q <= D;
		end if;
	end process;
end Behavior;