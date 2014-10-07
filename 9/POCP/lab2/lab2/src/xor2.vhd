-------------------------------------------------------------------------------
--
-- Title       : xor2
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : xor2.vhd
-- Generated   : Fri Oct  3 18:17:26 2014
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
--{entity {xor2} architecture {xor2}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity xor2 is
	 port(
		 A : in STD_LOGIC;
		 B : in STD_LOGIC;
		 Z : out STD_LOGIC
	     );
end xor2;

--}} End of automatically maintained section

architecture xor2 of xor2 is
begin

	 Z <= A xor B;

end xor2;
