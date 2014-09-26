-------------------------------------------------------------------------------
--
-- Title       : mux
-- Design      : lab1
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : mux.vhd
-- Generated   : Tue Sep 23 16:42:18 2014
-- From        : interface description file
-- By          : Itf2Vhdl ver. 1.22
--
-------------------------------------------------------------------------------
--
-- Description : 
--
-------------------------------------------------------------------------------

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity mux is
	port(
		A, B, S : in STD_LOGIC;	  
		Z : out STD_LOGIC
		);
end mux;

architecture beh of mux is
begin
	Z<=A when S='0' else B;
end beh;
