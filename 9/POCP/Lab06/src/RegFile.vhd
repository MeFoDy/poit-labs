library IEEE;
use IEEE.STD_LOGIC_1164.all; 
use IEEE.STD_LOGIC_ARITH.all;
use IEEE.STD_LOGIC_UNSIGNED.all;

entity RegFile is
	generic (
		INITREG: std_logic_vector := "0000";
		a: integer := 2);
	port (
		INIT: in std_logic;				 
		WDP: in std_logic_vector(INITREG'range);
		WA: in std_logic_vector(a-1 downto 0);
		RA: in std_logic_vector(a-1 downto 0);
		WE: in std_logic;
		RDP: out std_logic_vector(INITREG'range));
end RegFile;

architecture Beh of RegFile is
	component RegN is 
		generic (
			initreg: std_logic_vector := 	"1001");
		port (
			Din: in std_logic_vector(initreg'range);
			EN: in std_logic;
			INIT: in std_logic;
			CLK: in std_logic;
			OE: in std_logic;
			Dout: out std_logic_vector(initreg'range));
	end component;
	signal wen: std_logic_vector(2**a-1 downto 0);
	signal ren: std_logic_vector(2**a-1 downto 0);
	signal readd: std_logic_vector (initreg'range);
Begin
	WAD: process (WA)
	begin
		for i in 0 to 2**a - 1 	loop
			if i = conv_integer(WA) then
				wen (i) <= '1';
			else 
				wen (i) <= '0';
			end if;
		end loop;
	end process;
	
	RAD: process (RA)
	begin
		for i in 0 to 2**a - 1 	loop
			if i = conv_integer(RA) then
				ren (i) <= '1';
			else 
				ren (i) <= '0';
			end if;
		end loop;
	end process;
	
	Regi: for i in 2**a - 1 downto 0 generate
		Regi: Regn generic map (initreg)
		port map (WDP, wen(i), init, we, ren(i), readd);
	end generate;
	
	RDP <= readd;
End Beh;