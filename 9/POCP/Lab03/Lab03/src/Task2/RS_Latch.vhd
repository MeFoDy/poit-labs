library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity RS_Latch is
	port (
		R,S : in std_logic;
		Q, nQ : out std_logic
		);
end RS_Latch;

architecture Struct of RS_Latch is 
	component nor2 
		port (
			a, b: in std_logic;
			z : out std_logic);
	end component;
	signal t1, t2 : std_logic;
begin
	U1: nor2 port map (a => S, b => t2, z => t1);
	U2: nor2 port map (a => R, b => t1, z => t2);
	nQ <= t1;
	Q <= t2;
end Struct;

architecture Beh of RS_Latch is
	signal t1, t2: std_logic;
begin
	t2 <= R nor t1;
	t1 <= S nor t2;
	nQ <= t1;
	Q <= t2;
end Beh;