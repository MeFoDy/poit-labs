-------------------------------------------------------------------------------
--
-- Title       : inv
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : inv.vhd
-- Generated   : Fri Oct  3 17:29:58 2014
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
--{entity {inv} architecture {inv}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity inv is
	 port(
		 A : in STD_LOGIC;
		 Z : out STD_LOGIC
	     );
end inv;

--}} End of automatically maintained section

architecture inv of inv is
begin

	 Z <= not A;

end inv;
