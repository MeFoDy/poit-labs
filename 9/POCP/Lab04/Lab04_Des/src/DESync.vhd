library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity DESync is
	port (
		D, E, CLK : in std_logic;
		Q : out std_logic
		);
end DESync;

architecture Beh of DESync is
    signal data : std_logic;
begin
    process (E, CLK) 
	begin
		if (E = '1') then	   	
			if (rising_edge(CLK)) then
				data <= D;	
			end if;
		end if;
	end process;
	Q <= data;
end Beh;