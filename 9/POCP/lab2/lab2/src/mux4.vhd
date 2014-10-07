-------------------------------------------------------------------------------
--
-- Title       : mux4
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : mux4.vhd
-- Generated   : Fri Oct  3 17:48:23 2014
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
--{entity {mux4} architecture {mux4}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity mux4 is
	port(
		A : in STD_LOGIC;
		B : in STD_LOGIC;
		S : in STd_logic;
		A1 : in STD_LOGIC;
		B1 : in STD_LOGIC;
		Z : out STD_LOGIC;
		Z1 : out STD_LOGIC
		);
end mux4;

--}} End of automatically maintained section

architecture structural of mux4 is   
	component mux 
		Port(
			A, B, S: in std_logic;
			Z	   : out std_logic
			);
	end component; 
	
begin
	
	u1: mux port map (A, B, S, Z);
	u2: mux port map (A1, B1, S, Z1);
	
end structural;

architecture behavioral of mux4 is 
begin
	Z <= (A and S) or (B and not S);
	Z1 <= (A1 and S) or (B1 and not S);
end behavioral;