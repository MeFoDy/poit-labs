-------------------------------------------------------------------------------
--
-- Title       : or2
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : or2.vhd
-- Generated   : Fri Oct  3 17:29:18 2014
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
--{entity {or2} architecture {or2}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity or2 is
	 port(
		 A : in STD_LOGIC;
		 B : in STD_LOGIC;
		 Z : out STD_LOGIC
	     );
end or2;

--}} End of automatically maintained section

architecture or2 of or2 is
begin

	 Z <= A or B;

end or2;
