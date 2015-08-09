library ieee;
use ieee.std_logic_1164.all;

entity RAM_HAM_T is
end RAM_HAM_T;

architecture Beh of RAM_HAM_T is
	component RAM_Ham is
		generic(
		-- шина адреса
		m: integer := 2;
		-- шина данных
		n: integer := 4
		);
	port (
		-- синхронизация
		CLK: in std_logic;
		-- сигнал управления чтением/записью
		WR: in std_logic;
		-- шина адреса
		AB: in std_logic_vector (m-1 downto 0);
		-- 	двунаправленная шина данных
		DB: inout std_logic_vector (n-1 downto 0);
		ER: out std_logic
		);
	end component;
	signal CLK: std_logic := '0';
	signal WR: std_logic := '0';
	signal AB: std_logic_vector (1 downto 0);
	signal DB: std_logic_vector (3 downto 0);
	signal ER: std_logic := '0';
	constant CLK_period: time := 10 ns;
begin
	URAM: RAM_Ham port map(
	CLK => CLK,
	WR => WR,
	AB => AB,
	DB => DB,
	ER => ER
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
		wait for CLK_Period;
		AB <= "01";
		DB <= "1000";
		wait for CLK_Period;
		AB <= "10";
		DB <= "0100";
		wait for CLK_Period;
		WR <= '1';
		DB <= "ZZZZ";
		AB <= "01";
		wait for CLK_Period;
		DB <= "ZZZZ";
		AB <= "10";
		wait for CLK_Period;
		wait;
	end process;
end Beh;