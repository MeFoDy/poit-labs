library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity NOR2 is
	port (
	a, b: in std_logic;
	z : out std_logic
	);
end NOR2;
architecture Arch of NOR2 is
begin
	Z <= a nor b;
end Arch;