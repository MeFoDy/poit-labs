-------------------------------------------------------------------------------
--
-- Title       : task311
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : task311.vhd
-- Generated   : Fri Oct  3 18:34:24 2014
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
--{entity {task311} architecture {structural}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity task311 is
	port(
		X : in STD_LOGIC;
		Y : in STD_LOGIC;
		Z : in STD_LOGIC;
		F : out STD_LOGIC;
		G : out STD_LOGIC
		);
end task311;

--}} End of automatically maintained section

architecture structural of task311 is  
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
	signal x1,x2,x3,x4,x5,x6,x7:std_logic;
begin
	
	u1: inv port map (y, x1);
	u2: inv port map (x, x2);
	u3: and2 port map (x, y, x3);
	u4: and2 port map (y, z, x4);
	u5: and2 port map (x1, x2, x5);
	u6: and2 port map (x2, z, x6);
	u7: or2 port map (x3, x4, f);
	u8: or2 port map (x5, x6, g);
	
end structural;	  

architecture behavioral of task311 is  
begin
	f <= (x and y) or (y and z);
	g <= ((not x) and (not y)) or ((not x) and z);
end behavioral;
