library IEEE;
use IEEE.STD_LOGIC_1164.all; 
use IEEE.STD_LOGIC_ARITH.all;
use IEEE.STD_LOGIC_UNSIGNED.all;

entity LIFO_T is
end LIFO_T;

architecture Beh of LIFO_T is
	component LIFO is
		generic(
			-- шина адреса
			m: integer := 2;
			-- шина данных
			n: integer := 2
			);
		port (
			-- синхронизация
			CLK: in std_logic;
			-- сигнал управления чтением/записью
			WR: in std_logic;
			-- 	двунаправленная шина данных
			DB: inout std_logic_vector (n-1 downto 0);
			EMPTY: out std_logic;
			FULL: out std_logic
			);
	end component;
	signal CLK: std_logic := '0';
	signal WR: std_logic := '0';
	signal DB: std_logic_vector(1 downto 0) := "00";
	signal empty: std_logic;
	signal full: std_logic;
	constant CLK_Period: time := 10 ns;
begin
	ULIFO: LIFO port map(
		CLK => CLK,
		WR => WR,
		DB => DB,
		empty => empty,
		full => full
		);
		
	CLK_Process: process
	begin
		CLK <= '0';
		wait for CLK_Period/2;
		CLK <= '1';
		wait for CLK_Period/2;
	end process;
	
	main: process
	begin
		wait for clk_period;
		WR <= '0';
		DB <= "11";
		wait for clk_period;
		DB <= "10";
		wait for clk_period;
		DB <= "01";
		wait for clk_period;
		WR <= '1';
		DB <= "ZZ";
		wait for clk_period;
		DB <= "ZZ";
		wait for clk_period;
		DB <= "ZZ";
		wait for clk_period;
		DB <= "ZZ";
		wait;
	end process;
end Beh;