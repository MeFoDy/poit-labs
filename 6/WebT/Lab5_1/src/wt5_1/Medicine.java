/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package wt5_1;

/**
 *
 * @author Dark_MeFoDy
 */
public class Medicine {
    public String name;
    public String price;
    public String dosage;
    public String color;
    public String consistence;
    public String recommendation;
    
    public void print()
    {
        System.out.println("Name: "+name);
        System.out.println("Price: "+price);
        System.out.println("Dosage: "+dosage);
        System.out.println("Color: "+color);
        System.out.println("Consistence: "+consistence);
        System.out.println("Value: "+recommendation);
    }
}
