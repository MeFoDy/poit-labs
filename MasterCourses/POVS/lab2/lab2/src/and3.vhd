-------------------------------------------------------------------------------
--
-- Title       : and3
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : and3.vhd
-- Generated   : Fri Oct  3 18:46:42 2014
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
--{entity {and3} architecture {and3}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity and3 is
	 port(
		 A : in STD_LOGIC;
		 B : in STD_LOGIC;
		 C : in STD_LOGIC;
		 Z : out STD_LOGIC
	     );
end and3;

--}} End of automatically maintained section

architecture and3 of and3 is
begin

	 Z <= A and B and C;

end and3;
