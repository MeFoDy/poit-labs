library ieee;
use ieee.std_logic_1164.all;

entity JC is
	generic (i:integer := 2);
	port(
		CLK: in std_logic;
		RST: in std_logic;
		LS: in std_logic;
		Pin: in std_logic_vector(0 to 2**i-1);
		Pout: out std_logic_vector(0 to 2**i-1)
		);
end JC;

architecture Beh of JC is
	signal sreg: std_logic_vector(0 to 2**i-1);
	signal sdat: std_logic_vector(0 to 2**i-1);
Begin
	Main: process (CLK, RST, sdat)
	begin
		if RST = '1' then
			sreg <= (others => '0');
		elsif rising_edge(CLK) then
			sreg <= sdat;
		end if;
	end process;
	
	Data: process (LS, Pin, sreg)
	begin
		if LS = '0' then
			sdat <= Pin;
		else
			sdat <= not(sreg(2**i-1)) & sreg(0 to 2**i-2);
		end if;
	end process;
	
	Pout <= sreg;
End Beh;