-------------------------------------------------------------------------------
--
-- Title       : mult
-- Design      : lab1
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : mult.vhd
-- Generated   : Tue Sep 23 18:32:31 2014
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
--{entity {mult} architecture {mult}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity mult is
	port(
		I : in STD_LOGIC;
		O1 : out STD_LOGIC;
		O2 : out STD_LOGIC
		);
end mult;

--}} End of automatically maintained section

architecture mult of mult is
begin
	
	O2<=I;
	O1<=I;
	
end mult;
