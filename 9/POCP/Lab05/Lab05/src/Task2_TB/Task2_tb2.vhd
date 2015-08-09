-------------------------------------------------------------------------------
--
-- Title       : No Title
-- Design      : 
-- Author      : Shadowmaker
-- Company     : Home
--
-------------------------------------------------------------------------------
--
-- File        : E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task2_TB\Task2_tb2.vhd
-- Generated   : 10/18/14 16:01:26
-- From        : E:\Embedded\Projects\POCP\Lab05\Lab05\src\Task2.asf
-- By          : ASFTEST ver. v.2.1.3 build 56, August 25, 2005
--
-------------------------------------------------------------------------------
--
-- Description : 
--
-------------------------------------------------------------------------------

library IEEE;
use IEEE.std_logic_1164.all;
use IEEE.std_logic_arith.all;
use IEEE.std_logic_unsigned.all;


library IEEE;
use IEEE.STD_LOGIC_TEXTIO.all;
use STD.TEXTIO.all;

entity Task2_ent_tb2 is
end entity Task2_ent_tb2;

architecture Task2_arch_tb2 of Task2_ent_tb2 is
  constant delay_wr_in : Time := 5 ns;
  constant delay_pos_edge : Time := 5 ns;
  constant delay_wr_out : Time := 5 ns;
  constant delay_neg_edge : Time := 5 ns;

  file RESULTS : Text open WRITE_MODE is "results.txt";

  procedure WRITE_RESULTS(
    constant  CLK : in Std_logic;
    constant  RST : in Std_logic;
    constant  IP : in Std_logic_Vector (3 downto 0);
    constant  OP : in Std_logic_Vector (1 downto 0)
 ) is
     variable l_out : Line;
  begin
     WRITE(l_out, now, right, 15, ps);
     -- write input signals
     WRITE(l_out, CLK, right, 8);
     WRITE(l_out, RST, right, 8);
     WRITE(l_out, IP, right, 11);
     -- write output signals
     WRITE(l_out, OP, right, 9);
     WRITELINE(RESULTS, l_out);
  end;

  component Task2 is
    port(
      CLK : in Std_logic;
      RST : in Std_logic;
      IP : in Std_logic_Vector (3 downto 0);
      OP :out Std_logic_Vector (1 downto 0));
  end component; -- Task2;

 signal CLK : Std_logic;
 signal RST : Std_logic;
 signal IP : Std_logic_Vector (3 downto 0);
 signal OP : Std_logic_Vector (1 downto 0);

 signal cycle_num : Integer; -- takt number

-- this signal is added for compare test simulation results only
type test_state_type is (S0, S1, S2, S3, S4, any_state);
signal  test_state : test_state_type;


begin
   UUT : Task2
   port map(
    CLK => CLK,
    RST => RST,
    IP => IP,
    OP => OP);

 STIMULI : process
 begin
 --  Test for all transition of finite state machine

   CLK <= '0';   
   cycle_num <= 0;           
   wait for delay_wr_in;
   RST <= '1';
   IP <= "0000";

   wait for delay_pos_edge;
   test_state <= S0;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S0

   CLK <= '0';   
   cycle_num <= 1;           
   wait for delay_wr_in;
   RST <= '0';
   IP <= "0000";

   wait for delay_pos_edge;
   test_state <= S0;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S0

   CLK <= '0';   
   cycle_num <= 2;           
   wait for delay_wr_in;
   RST <= '0';
   IP <= "0011";

   wait for delay_pos_edge;
   test_state <= S1;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S1

   CLK <= '0';   
   cycle_num <= 3;           
   wait for delay_wr_in;
   RST <= '0';
   IP <= "0000";

   wait for delay_pos_edge;
   test_state <= S1;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S1

   CLK <= '0';   
   cycle_num <= 4;           
   wait for delay_wr_in;
   RST <= '0';
   IP <= "1111";

   wait for delay_pos_edge;
   test_state <= S2;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S2

   CLK <= '0';   
   cycle_num <= 5;           
   wait for delay_wr_in;
   RST <= '0';
   IP <= "0000";

   wait for delay_pos_edge;
   test_state <= S2;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S2

   CLK <= '0';   
   cycle_num <= 6;           
   wait for delay_wr_in;
   RST <= '0';
   IP <= "1100";

   wait for delay_pos_edge;
   test_state <= S3;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S3

   CLK <= '0';   
   cycle_num <= 7;           
   wait for delay_wr_in;
   RST <= '0';
   IP <= "0001";

   wait for delay_pos_edge;
   test_state <= S3;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S3

   CLK <= '0';   
   cycle_num <= 8;           
   wait for delay_wr_in;
   RST <= '0';
   IP <= "0000";

   wait for delay_pos_edge;
   test_state <= S4;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S4

   CLK <= '0';   
   cycle_num <= 9;           
   wait for delay_wr_in;
   RST <= '0';

   wait for delay_pos_edge;
   test_state <= S4;
   CLK <= '1';
   wait for delay_wr_out;
   wait for delay_neg_edge; -- S4


 -- Test length 10
  wait;      -- stop simulation
 end process; -- STIMULI;

 WRITE_RESULTS(CLK,RST,IP,OP);

end architecture Task2_arch_tb2;

configuration Task2_cfg_tb2 of Task2_ent_tb2 is
   for Task2_arch_tb2
      for UUT : Task2  use entity work.Task2(Beh);
      end for;
   end for;
end Task2_cfg_tb2;
