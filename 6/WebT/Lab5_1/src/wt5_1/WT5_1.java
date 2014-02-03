/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package wt5_1;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;
import javax.xml.transform.Result;
import javax.xml.transform.Source;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerConfigurationException;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.stream.StreamResult;
import javax.xml.transform.stream.StreamSource;
import org.w3c.dom.Document;
import org.w3c.dom.Node;
import org.w3c.dom.NodeList;
import org.xml.sax.HandlerBase;
import org.xml.sax.SAXException;

/**
 * @author Dark_MeFoDy
 */
public class WT5_1 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws ParserConfigurationException, SAXException, IOException {
        // TODO code application logic here
        try {
            testParseDocument(true, null, "D:\\xml_java.xml");
        } catch (Exception ex) {
            System.err.println(ex);
            return;
        }

        ArrayList<Medicine> my_array = parse("D:\\xml_java.xml");

        for (int q = 0; q < my_array.size(); q++) {
            System.out.println("======= Element " + (q + 1));
            my_array.get(q).print();
        }
        
        Sort(my_array);
        
        try {
            Transform("D:\\xml_java.xml", "D:\\xml_java.html", "D:\\java.xsl");
        } catch (SAXException | IOException | TransformerException ex) {
            System.out.println(ex);
        }

    }

    static void Transform(String inpath, String outpath, String xslin)
            throws SAXException, IOException, TransformerConfigurationException, TransformerException {

        try {
            TransformerFactory tFactory = TransformerFactory.newInstance();

            Transformer transformer =
                    tFactory.newTransformer(new javax.xml.transform.stream.StreamSource(xslin));

            transformer.transform(new javax.xml.transform.stream.StreamSource(inpath),
                    new javax.xml.transform.stream.StreamResult(new FileOutputStream(outpath)));
        } catch (TransformerException e) {
            // Handle.
        }
        //newTransformer(stylesource);
    }

    protected static ArrayList<Medicine> parse(String path)
            throws ParserConfigurationException, SAXException, IOException {
        ArrayList<Medicine> out_list = new ArrayList<>();

        File input = new File(path);
        Document q = DocumentBuilderFactory.newInstance().newDocumentBuilder().parse(input);

        Node qw = q.getDocumentElement();

        NodeList nodeList = qw.getChildNodes();

        for (int t = 0; t < nodeList.getLength(); t++) {
            if (nodeList.item(t).getNodeName().equals("drug")) {
                Medicine el = getNode(nodeList.item(t));
                out_list.add(el);
            }
        }

        return out_list;
    }

    private static Medicine getNode(Node inp) {
        NodeList params = inp.getChildNodes();

        Medicine out_g = new Medicine();

        for (int q = 0; q < params.getLength(); q++) {
            Node tmp = params.item(q);
            if (tmp.getNodeName().equals("name")) {
                out_g.name = tmp.getChildNodes().item(0).getNodeValue();
            }

            if (tmp.getNodeName().equals("price")) {
                out_g.price = tmp.getChildNodes().item(0).getNodeValue();
            }
            if (tmp.getNodeName().equals("dosage")) {
                out_g.dosage = tmp.getChildNodes().item(0).getNodeValue();
            }

            if (tmp.getNodeName().equals("visual")) {
                NodeList vis = tmp.getChildNodes();

                for (int w = 0; w < vis.getLength(); w++) {
                    Node tmp_in = vis.item(w);
                    if (tmp_in.getNodeName().equals("color")) {
                        out_g.color = tmp_in.getChildNodes().item(0).getNodeValue();
                    }
                    if (tmp_in.getNodeName().equals("consistence")) {
                        out_g.consistence = tmp_in.getChildNodes().item(0).getNodeValue();
                    }
                    if (tmp_in.getNodeName().equals("recommendation")) {
                        out_g.recommendation = tmp_in.getChildNodes().item(0).getNodeValue();
                    }
                }
            }
        }

        return out_g;
    }

    protected static void testParseDocument(boolean isValidating, HandlerBase handler, String sFilename) {
        try {
            // Get a "parser factory", an object that creates parsers
            SAXParserFactory saxParserFactory = SAXParserFactory.newInstance();

            // Set up the factory to create the appropriate type of parser
            saxParserFactory.setValidating(isValidating);
            saxParserFactory.setNamespaceAware(false); // Не этот месяц...

            SAXParser parser = saxParserFactory.newSAXParser();

            parser.parse(new File(sFilename), handler);

        } catch (ParserConfigurationException | SAXException | IOException ex) {
            System.err.println("Exception: " + ex);
            System.exit(2);
        }



    }

    private static ArrayList<Medicine> Sort(ArrayList<Medicine> my_array) {
        for (int i=0; i<my_array.size(); i++) {
            for (int j=i+1; j<my_array.size(); j++) {
                if (my_array.get(j).price.compareTo(my_array.get(j-1).price) > 0) {
                    Medicine temp = my_array.get(j);
                    my_array.set(j, my_array.get(i));
                    my_array.set(i, temp);
                }
            }
        }
        return my_array;
    }
}
