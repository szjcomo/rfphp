### ˼�ǽݿƼ� refinephp ���ʹ��˵��

- refinephp ��һ�����easyswoole�Ŀ��ٿ�����php��ܣ���ԭ�е�easyswoole�Ļ�������ǿ�˶�ʱ��������Ͷ�ݵȹ��ܣ��������ò��������������·�ɲ������Լ�reqeust��response�Ȳ����ĸ�����

refinephp ������˵��
-------------

### Controller
                
----
#### �����ռ䣺` szjcomo\szjcore\Controller ` 
                    
> �̳��� EasySwoole\Http\AbstractInterface\Controller

#### �����б�

|  ���� | ��������   | ����˵��  |  ����˵�� |
| ------------ | ------------ | ------------ | ------------ |
| public  | index()  | ��  | easyswoole �涨�̳��Կ���������ʵ��index����  |
| public  | session($key,$value)  | key,value  | ��ȡsession������session��ֵ  |
| public  | appResult($info,$data,$err)  | info,data,err  | ͳһapp����ֵ,info ����˵�� data������ err�Ƿ���ȷ  |
| public  | appJson($data,$code)  |data,code  | ��ӦJSON����,codeĬ����200  |
| public  | initialize()  |�� | ȫ�������¼�������Ȩ�޿�������������������ɣ�����false������ִ�к���ĳ��� ����true����ִ��  |
| public  | onRequest()  |�� | ��д��easyswoole��onRequest()�¼�����ǿ��context���ܣ�������������д���������ʵ��initialize()�¼�����  |
| public  | onException()  |�� | ��д��easyswoole��onException�¼����������������,ͳһ����json��ʽ������Ϣ  |
| public  | _emtpy($action)  |action | δ���󵽷����ղ�������,����ɸ���ҵ����Ҫ�Զ���ʵ��  |

#### �����б�

|  ���� | ������  |  ʵ�ַ��� |  ����˵�� |
| ------------ | ------------ | ------------ | ------------ |
|  Protected | $context  |  method��get�ȵ� | ����������������Ļ��� ��������ɲ鿴�·�Context��  |
|  Protected | $_session  |  set��get�ȵ� | ԭ����easyswoole��session ����ɲ鿴�ٷ�session�ĵ�  |


### ViewController
                
----
#### �����ռ䣺` szjcomo\szjcore\ViewController `
                    
> �̳��� szjcomo\szjcore\Controller ģ��������õ�think-template �������ǰ��˷������Ŀ ��ֱ�Ӽ̳�Controller�� ���ؼ̳д��� ֻ�����õ�View������²ż̳д���

####   �����б�

|  ���� | ��������   | ����˵��  |  ����˵�� |
| ------------ | ------------ | ------------ | ------------ |
| public  | fetch($template)  | ģ��·��  | Ѱ�Ҹ�Ŀ¼��templates�µ�ģ���ļ�  |

#### �����б�

|  ���� | ������  |  ʵ�ַ��� |  ����˵�� |
| ------------ | ------------ | ------------ | ------------ |
|  Protected | $view  |  assign�ȵ� | ����ɲ鿴thinkphp template�ٷ�˵��  |


