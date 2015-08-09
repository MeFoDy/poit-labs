library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity AND2 is
	port (
	a, b: in std_logic;
	z : out std_logic
	);
end And2;
architecture Arch of AND2 is
begin
	Z <= a and b;
end Arch;