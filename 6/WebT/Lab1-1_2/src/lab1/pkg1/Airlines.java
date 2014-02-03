package lab1.pkg1;

import java.util.*;
import java.text.DateFormat;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Dark_MeFoDy
 */

enum dayOfWeek {
        MONDAY, TUESDAY, THIRSDAY, WEDNESDAY, FRIDAY, SATURDAY, SUNDAY
    }

public class Airlines {
    
    private int num; //номер рейса
    private String kuda; //пункт назначения
    private String type; //тип самолета
    private Date time; //время вылета
    private dayOfWeek day; //день недели
    
    private Airlines[] airlines;
    
    public Airlines(int num, String kuda, String type, Date time, dayOfWeek day) {
        this.num = num;
        this.kuda = kuda;
        this.type = type;
        this.time = time;
        this.day = day;
    }
    
    public static Airlines[] generateArray() {
        Airlines[] airlinesArray;
        airlinesArray = new Airlines[10];
        airlinesArray[0] = new Airlines(1, "Minsk", "Boing", new Date(55555555), dayOfWeek.MONDAY);
        airlinesArray[1] = new Airlines(2, "Moscow", "Boing", new Date(6666666), dayOfWeek.WEDNESDAY);
        airlinesArray[2] = new Airlines(3, "Minsk", "Boing", new Date(55555555), dayOfWeek.TUESDAY);
        airlinesArray[3] = new Airlines(4, "Tallin", "Boing", new Date(11111), dayOfWeek.TUESDAY);
        airlinesArray[4] = new Airlines(5, "Minsk", "Boing", new Date(555525555), dayOfWeek.FRIDAY);
        airlinesArray[5] = new Airlines(6, "London", "Boing", new Date(555535555), dayOfWeek.MONDAY);
        airlinesArray[6] = new Airlines(7, "Paris", "Boing", new Date(555455555), dayOfWeek.SUNDAY);
        airlinesArray[7] = new Airlines(8, "Berlin", "Boing", new Date(556555555), dayOfWeek.SATURDAY);
        airlinesArray[8] = new Airlines(9, "Brest", "Boing", new Date(755555555), dayOfWeek.MONDAY);
        airlinesArray[9] = new Airlines(10, "Gomel", "Boing", new Date(955555555), dayOfWeek.MONDAY);
        
        return airlinesArray;
    }
    
    @Override
    public String toString() {
        return type + " № " + num + " to " + kuda + ", " + day + " : " + time.getTime();
    }
        
    public int getNum() {
        return num;
    }
    public String getKuda() {
        return kuda;
    }
    public String getType() {
        return type;
    }
    public dayOfWeek getDay(){
        return day;
    }
    public Date getTime() {
        return time;
    }
    
    public void setNum (int num) {
        this.num = num;
    }    
    public void setKuda (String kuda) {
        this.kuda = kuda;
    }
    public void setType(String type) {
        this.type = type;
    }
    public void setDay(dayOfWeek day) {
        this.day = day;
    }
    public void setTime(Date time) {
        this.time = time;
    } 
    
}
