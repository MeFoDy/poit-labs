-------------------------------------------------------------------------------
--
-- Title       : RS_latch
-- Design      : lab3
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : RS_latch.vhd
-- Generated   : Fri Dec 12 13:46:57 2014
-- From        : interface description file
-- By          : Itf2Vhdl ver. 1.22
--
-------------------------------------------------------------------------------
--
-- Description : 
--
-------------------------------------------------------------------------------

--{{ Section below this comment is automatically maintained
--   and may be overwritten
--{entity {RS_latch} architecture {RS_latch}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity RS_latch is
	port(
		S : in STD_LOGIC;
		R : in STD_LOGIC;
		Q : out STD_LOGIC;
		nQ : out STD_LOGIC
		);
end RS_latch;

--}} End of automatically maintained section

architecture Struct of RS_latch is   
	
	component NOR2 
		port  (
			a, b: in std_logic;
			z: out std_logic
			);
	end component;
	signal t1, t2: std_logic;
begin
	
	U1: nor2 port map  (S, t2, t1);
	U2: nor2 port map  (t1, R, t2);
	nQ <= t1;
	Q <= t2;
	
end Struct;

architecture Beh of RS_latch is
	signal t1, t2: std_logic;
begin
	t2 <= R nor t1;
	t1 <= S nor t2;
	nQ <= t1;
	Q <= t2;
	
end Beh;
