-------------------------------------------------------------------------------
--
-- Title       : or3
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : or3.vhd
-- Generated   : Fri Oct  3 18:47:17 2014
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
--{entity {or3} architecture {or3}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity or3 is
	 port(
		 A : in STD_LOGIC;
		 B : in STD_LOGIC;
		 C : in STD_LOGIC;
		 Z : out STD_LOGIC
	     );
end or3;

--}} End of automatically maintained section

architecture or3 of or3 is
begin

	 Z <= A or B or C;

end or3;
