-------------------------------------------------------------------------------
--
-- Title       : summ1
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : summ1.vhd
-- Generated   : Fri Oct  3 18:01:09 2014
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
--{entity {summ1} architecture {summ1}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity summ1 is
	port(
		A : in STD_LOGIC;
		B : in STD_LOGIC;
		N : in STD_LOGIC;
		S : out STD_LOGIC;
		P : out STD_LOGIC
		);
end summ1;

--}} End of automatically maintained section

architecture structural of summ1 is	
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
	component xor2	  
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
	signal x1, x2, x3: std_logic;
begin
	u1: xor2 port map (A, B, X1);
	u2: xor2 port map (X1, N, S);
	u3: and2 port map (A, B, X2);
	u4: and2 port map (X1, N, X3);
	u5: or2 port map (X2, X3, P);
end structural;

architecture behavioral of summ1 is	 
	signal temp: std_logic;
begin 
	temp <= A xor B;
	S <= temp xor N;
	P <= (A and B) or (temp and N);
end behavioral;