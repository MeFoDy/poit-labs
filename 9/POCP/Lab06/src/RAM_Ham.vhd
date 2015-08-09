library IEEE;
use IEEE.STD_LOGIC_1164.all; 
use IEEE.STD_LOGIC_ARITH.all;
use IEEE.STD_LOGIC_UNSIGNED.all;

entity RAM_Ham is
	generic(
		m: integer := 2;
		n: integer := 4
		);
	port (
		CLK: in std_logic;
		WR: in std_logic;
		AB: in std_logic_vector (m-1 downto 0);
		DB: inout std_logic_vector (n-1 downto 0);
		ER: out std_logic
		);
end RAM_Ham;

architecture Beh of RAM_Ham is
	subtype word is std_logic_vector (n+2 downto 0);
	type tram is array (0 to 2**m - 1) of word;
	signal sRAM: tram;
	signal addrreg: integer range 0 to 2**m - 1;
	signal buf: std_logic_vector (n-1 downto 0);
Begin
	addrreg <= CONV_INTEGER(AB);
	
	WRP: process (WR, CLK, addrreg, DB)
		variable r1, r2, r3: std_logic;
	begin
		if WR = '0' then
			if rising_edge(CLK) then
				r1 := DB(0) xor DB(1) xor DB(2);
				r2 := DB(1) xor DB(2) xor DB(3);
				r3 := DB(0) xor DB(1) xor DB(3);
				sRAM(addrreg) <= r3 & r2 & r1 & DB;
			end if;
		end if;
	end process;
	
	RDP: process(WR, sRAM, addrreg)
		variable s1, s2, s3 : std_logic;
	begin
		if WR = '1' then
			s1 := sRAM(addrreg)(0) xor sRAM(addrreg)(1) xor sRAM(addrreg)(2) xor sRAM(addrreg)(n);
			s2 := sRAM(addrreg)(1) xor sRAM(addrreg)(2) xor sRAM(addrreg)(3) xor sRAM(addrreg)(n + 1);
			s3 := sRAM(addrreg)(0) xor sRAM(addrreg)(1) xor sRAM(addrreg)(3) xor sRAM(addrreg)(n + 2);
			ER <= s1 or s2 or s3;
			DB <= sRAM (addrreg)(n-1 downto 0);
		else
			DB <= (others => 'Z');
		end if;
	end process;
end Beh;