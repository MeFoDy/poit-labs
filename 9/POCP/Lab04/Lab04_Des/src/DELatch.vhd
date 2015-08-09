library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity D_Enable_Latch is
	port (
		D, E : in std_logic;
		Q : out std_logic
		);
end D_Enable_Latch;

architecture Beh of D_Enable_Latch is
    signal data : std_logic;
begin
    data <= D when (E = '1') else data;
    Q <= data;
end Beh;