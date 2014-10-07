-------------------------------------------------------------------------------
--
-- Title       : mux
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : mux.vhd
-- Generated   : Fri Oct  3 17:16:10 2014
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
--{entity {mux} architecture {mux}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity mux is
	port(
		A : in STD_LOGIC;
		B : in STD_LOGIC;
		S : in STD_LOGIC;
		Z : out STD_LOGIC
		);
end mux;

--}} End of automatically maintained section

architecture structural of mux is
	component and2	  
		Port(
			A,B:in std_logic;
			Z:out std_logic
			);
	end component;
	component or2	  
		Port(
			A,B:in std_logic;
			Z:out std_logic
			);
	end component; 
	component inv	  
		Port(
			A:in std_logic;
			Z:out std_logic
			);
	end component;
	signal x1,x2,x3:std_logic;
begin
	
	u1: and2 port map (B, S, X1);
	u2: inv port map (S, X2);
	u3: and2 port map (A, X2, X3);
	u4: or2 port map (X1, X3, Z);
	
end structural;

architecture behavioral of mux is
begin
	Z <= (A and S) or (B and not S);
end behavioral;