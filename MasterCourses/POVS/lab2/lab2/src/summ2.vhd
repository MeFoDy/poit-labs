-------------------------------------------------------------------------------
--
-- Title       : summ2
-- Design      : lab2
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : summ2.vhd
-- Generated   : Fri Oct  3 18:23:06 2014
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
--{entity {summ2} architecture {structural}}

library IEEE;
use IEEE.STD_LOGIC_1164.all;

entity summ2 is	  
	Port(
		a: in STD_Logic_Vector(1 downto 0);
		b: in STD_Logic_Vector(1 downto 0);
		n: in STD_Logic;
		s: out STD_Logic_Vector(1 downto 0);
		p: out STD_Logic
		);
end summ2;

--}} End of automatically maintained section

architecture structural of summ2 is
	component summ1
		Port(
			a,b,n: in std_logic;
			s,p : out std_logic
			);
	end component;
	signal temp : std_logic;
begin
	U1: summ1 port map (a(0),b(0),n,s(0),temp);
	U2: summ1 port map (a(1),b(1),temp,s(1),p);
end structural;

architecture behavioral of summ2 is
	signal temp : std_logic;
	signal xorAB : std_logic_vector(1 downto 0);
begin		 
	xorAB <= a xor b;
	s(0) <= xorAB(0) xor n;
	temp <= (a(0) and b(0)) or (xorAB(0) and n);
	s(1) <= xorAB(1) xor temp;
	p <= (a(1) and b(1)) or (xorAB(1) and temp);
end behavioral;
