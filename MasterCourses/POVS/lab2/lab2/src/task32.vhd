-------------------------------------------------------------------------------
--
-- Title       : task32
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : task32.vhd
-- Generated   : Fri Oct  3 18:49:32 2014
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
--{entity {task32} architecture {structural}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity task32 is
	 port(
		 X : in STD_LOGIC;
		 Y : in STD_LOGIC;
		 Z : in STD_LOGIC;
		 F : out STD_LOGIC
	     );
end task32;

--}} End of automatically maintained section

architecture structural of task32 is  
component and2	  
		Port(
			A,B:in std_logic;
			Z:out std_logic
			);
	end component;	   
	component and3	  
		Port(
			A,B,C:in std_logic;
			Z:out std_logic
			);
	end component;	 
	component or3	  
		Port(
			A,B,C:in std_logic;
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
	signal x1,x2,x3,x4,x5,x6:std_logic;
begin

	u1: inv port map (x, x1);
	u2: inv port map (y, x2);
	u3: inv port map (z, x3);
	u4: and2 port map (x, z, x4);
	u5: and2 port map (x2, z, x5);
	u6: and3 port map (x1, y, x3, x6);
	u7: or3 port map (x4, x5, x6, f);

end structural;	

architecture behavioral of task32 is
begin
	f <= (x and z) or (not y and z) or (not x and y and not z);
end behavioral;
