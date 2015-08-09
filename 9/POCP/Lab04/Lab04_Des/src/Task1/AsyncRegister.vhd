library ieee;
use ieee.std_logic_1164.all;

entity AsyncRegister is
	generic (n: integer := 4);
	port (
		Din : std_logic_vector(n-1 downto 0);
		EN: in std_logic;
		Dout: out std_logic_vector(n-1 downto 0)
		);
end AsyncRegister;

architecture Struct of AsyncRegister is
	component D_Enable_Latch
		port (
			D, E : in std_logic;
			Q : out std_logic
			);
	end component;
	signal buf: std_logic_vector(n-1 downto 0);
Begin
	sch: for i in n-1 downto 0 generate
		U_J: D_Enable_Latch port map(DIn(i), en, buf(i));
	end generate;
	Dout <= buf;
End Struct;

architecture Beh of AsyncRegister is
	signal buf: std_logic_vector(n-1 downto 0);
Begin
	Main: process (Din, EN)
	begin
		if (EN = '1')  then
			buf <= Din;
		end if;
	end process;
	Dout <= buf;
End	Beh;