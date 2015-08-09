library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity Inv is
	port (
	a: in std_logic;
	z : out std_logic
	);
end Inv;
architecture Arch of Inv is
begin
	Z <= not a;
end Arch;
