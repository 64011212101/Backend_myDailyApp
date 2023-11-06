import java.util.Scanner;

public class test {
    public static void main(String[] args) {
        Scanner sc=new Scanner(System.in);
        BinaryS bi=null;
        int menu;
        int nodes;
        while (true) {
            System.out.print("1 : Insert data \n"
                +"2 : Delete data \n"
                +"3 : Traversal \n"
                +"4 : Exit\n"
                +"choose menu : " );
            menu=sc.nextInt();
            if(menu==1){
                System.out.print("Insert Node : ");
                nodes=sc.nextInt();
                if(bi==null){
                    bi=new BinaryS(nodes);
                }
                else{
                    bi.add(nodes);
                }
            }
            else if(menu==2){
                
            }
            else if(menu==3){
                System.out.print("Preorder \t: ");
                bi.preO();
                System.out.print("Inorder \t: ");
                bi.inO();
                System.out.print("Postorder \t: ");
                bi.postO();
            }
            else if(menu==4){
                break;
            }
        }
    }
}
class Node{
    int data;
    Node head;
    Node tail;
    Node(int data){
        this.data=data;
    }
}
class BinaryS {
    Node root;
    public BinaryS(int i){
        root =new Node(i);
    }
    public void add(int i){
        Node n=new Node(i);
        Node tc=root;
        while(tc!=null){
            if(i>tc.data){
                if(tc.tail==null){
                    tc.tail=n;
                    break;
                }
                tc=tc.tail;
            }
            else{
                if(tc.head==null){
                    tc.head=n;
                    break;
                }
                tc=tc.head;
            }
        }
    }
    public void delete(){
        
    }
    public void preO(){
        Node tc=root;
        preO(tc);
        System.out.println();
    }
    public void preO(Node n){
        if(n==null)return;
        System.out.print(n.data+" ");
        preO(n.head);
        preO(n.tail);
    }
    public void inO(){
        Node tc=root;
        inO(tc);
        System.out.println();
    }
    public void inO(Node n){
        if(n==null)return;
        inO(n.head);
        System.out.print(n.data+" ");
        inO(n.tail);
    }
    public void postO(){
        Node tc=root;
        postO(tc);
        System.out.println();
    }
    public void postO(Node n){
        if(n==null)return;
        postO(n.head);
        postO(n.tail);
        System.out.print(n.data+" ");
    }

    
}