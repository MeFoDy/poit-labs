library ieee;
use ieee.std_logic_1164.all;

entity ShiftReg is
	generic (N: integer:= 3);
	port(
		Din, CE, CLK, CLR: in std_logic;
		Dout: out std_logic_vector(N-1 downto 0)
	);
end ShiftReg;				  

architecture Beh of ShiftReg is	 
	signal outS: std_logic_vector(N-1 downto 0);
begin		  
	process(CLR, CLK) 
	begin  		
		if (CLR = '1') then
			outS <= (others => '0');	  
		elsif (rising_edge(CLK)) then
			if (CE = '1') then		  
				outS(0) <= Din;
				for i in 1 to N-1 loop 
              		outS(i) <= outS(i-1); 
            	end loop; 
			end if;
		end if;
	end process; 
	Dout <= outS; 
end Beh;