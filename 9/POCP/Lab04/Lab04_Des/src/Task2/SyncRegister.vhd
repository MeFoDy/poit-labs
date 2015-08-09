library ieee;
use ieee.std_logic_1164.all;

entity SyncReg is
	generic (n: integer := 4);
	port
		(
		Din: in std_logic_vector(n-1 downto 0);
		EN: in std_logic;
		CLK: in std_logic;
		DOut: out std_logic_vector(n-1 downto 0)
		);
end SyncReg;

architecture Struct of SyncReg is
	component DESync
		port (
			D, E, CLK : in std_logic;
			Q : out std_logic
			);
	end component;
	signal buf: std_logic_vector(n-1 downto 0);
Begin
	sch: for i in n-1 downto 0 generate
		U_J: DESync port map(DIn(i), en, CLK, buf(i));
	end generate;
	Dout <= buf;
End Struct;

Architecture Beh of SyncReg is
	signal reg: std_logic_vector(n-1 downto 0);
Begin
	Main: process (Din, EN, CLK)
	begin
		if en = '1' then
			if (rising_edge(CLK)) then
				reg <= Din;
			end if;
		end if;
	end process;
	DOut <= reg;
End Beh;