/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package lab2;

/**
 *
 * @author Dark_MeFoDy
 */
public class Lab2 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        Abonent ab = new Abonent("Ivanov I.I.", "2922929");
        Usluga u = new Usluga("Usluga");
        Admin ad = new Admin("Adminov A.A.");
        
        ab.Oplatit(u);
        ab.Popros(ad, "1234567");
        
        ab.Otkaz();
        
        ad.ChangeUsluga(u);
        ad.Otkl(ab);
    }
}
