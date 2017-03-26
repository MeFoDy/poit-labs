-------------------------------------------------------------------------------
--
-- Title       : BiStableElement
-- Design      : lab3
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : BiStableElement.vhd
-- Generated   : Fri Dec 12 13:34:45 2014
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
--{entity {BiStableElement} architecture {BiStableElement}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity BiStableElement is
	 port(
		 Q : out STD_LOGIC;
		 nQ : out STD_LOGIC
	     );
end BiStableElement;

--}} End of automatically maintained section

architecture BiStableElement of BiStableElement is 

component Inv 
	port  (
	a: in std_logic;
	z: out std_logic
	);
end component;
signal t1, t2: std_logic;

begin

	U1: inv port map (a => t1, z => t2);
	U2: inv port map (a => t2, z => t1);
	nQ <= transport t1 after 10ns;
	Q <= transport t2 after 15ns;

end BiStableElement;
