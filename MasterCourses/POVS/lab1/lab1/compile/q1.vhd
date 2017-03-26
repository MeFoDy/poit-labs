-------------------------------------------------------------------------------
--
-- Title       : q
-- Design      : lab1
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : c:\My_Designs\lab1\lab1\compile\q1.vhd
-- Generated   : Tue Sep 23 20:38:45 2014
-- From        : c:\My_Designs\lab1\lab1\src\q1.bde
-- By          : Bde2Vhdl ver. 2.6
--
-------------------------------------------------------------------------------
--
-- Description : 
--
-------------------------------------------------------------------------------
-- Design unit header --
library IEEE;
use IEEE.std_logic_1164.all;


entity q is
  port(
       in1 : in STD_LOGIC;
       in2 : in STD_LOGIC;
       in3 : in STD_LOGIC;
       Q : out STD_LOGIC
  );
end q;

architecture q of q is

---- Signal declarations used on the diagram ----

signal NET251 : STD_LOGIC;
signal NET265 : STD_LOGIC;
signal NET274 : STD_LOGIC;

begin

----  Component instantiations  ----

NET274 <= in2 and in1;

NET265 <= in3 and NET251;

NET251 <= not(in2);

Q <= NET265 or NET274;


end q;
