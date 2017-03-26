-------------------------------------------------------------------------------
--
-- Title       : and2
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : and2.vhd
-- Generated   : Fri Oct  3 17:28:04 2014
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
--{entity {and2} architecture {and2}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity and2 is
	 port(
		 A : in STD_LOGIC;
		 B : in STD_LOGIC;
		 Z : out STD_LOGIC
	     );
end and2;

--}} End of automatically maintained section

architecture and2 of and2 is
begin

	 Z <= A and B;

end and2;
