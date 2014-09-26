-------------------------------------------------------------------------------
--
-- Title       : mux4
-- Design      : lab1
-- Author      : Dark MeFoDy
-- Company     : BSUIR
--
-------------------------------------------------------------------------------
--
-- File        : c:\My_Designs\lab1\lab1\compile\mux4.vhd
-- Generated   : Tue Sep 23 20:29:22 2014
-- From        : c:\My_Designs\lab1\lab1\src\mux4.bde
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


entity mux4 is
  port(
       A1 : in STD_LOGIC;
       A2 : in STD_LOGIC;
       B1 : in STD_LOGIC;
       B2 : in STD_LOGIC;
       S : in STD_LOGIC;
       Aout : out STD_LOGIC;
       Bout : out STD_LOGIC
  );
end mux4;

architecture mux4 of mux4 is

---- Component declarations -----

component mux
  port (
       A : in STD_LOGIC;
       B : in STD_LOGIC;
       S : in STD_LOGIC;
       Z : out STD_LOGIC
  );
end component;

begin

----  Component instantiations  ----

Mux1 : mux
  port map(
       A => A1,
       B => A2,
       S => S,
       Z => Aout
  );

Mux2 : mux
  port map(
       A => B1,
       B => B2,
       S => S,
       Z => Bout
  );


end mux4;
