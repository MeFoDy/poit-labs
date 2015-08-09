library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity BistableElement is
	port (
		Q: out std_logic;
		nQ: out std_logic
		);
end BistableElement;

architecture Struct of BistableElement is
	component Inv
		port (
			a: in std_logic;
			z: out std_logic);
	end component;
	signal t1, t2: std_logic;
begin
	U1: inv port map (a => t2, z => t1);
	U2: inv port map (a => t1, z => t2);
	nQ <= transport t1 after 10 ns;
	Q <= transport t2 after 15 ns;
end Struct; 