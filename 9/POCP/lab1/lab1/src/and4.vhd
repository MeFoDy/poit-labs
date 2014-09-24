-------------------------------------------------------------------------------
--
-- Title       : and4
-- Design      : lab1
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : and4.vhd
-- Generated   : Tue Sep 23 17:56:17 2014
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
--{entity {and4} architecture {and4}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity and4 is
	port(
		A1, A2, A3, A4 : in STD_LOGIC;
		Z : out STD_LOGIC
		);
end and4;

--}} End of automatically maintained section

architecture and4 of and4 is
begin	   	 
	   Z<=A1 and A2 and A3 and A4;
end and4;
