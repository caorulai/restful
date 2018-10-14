## 1. RESTful是什么
```
本质：是一种软件架构风格
核心：面向资源
解决的问题：降低开发的复杂性；提高系统的可伸缩性
```
### 1.1 设计概念和准则
```
1. 网络上的所有事物都可以被抽象为资源
2. 每一个资源都有唯一的资源标识，对资源的操作不会改变这些标识
3. 所有的操作都是无状态的
```

### 1.2 资源
```
所谓"资源"，就是网络上的一个实体，或者说是网上的一个具体信息
```

## 2. HTTP协议
### 2.1 HTTP协议-URL
```
HTTP是一个属于应用层的协议，特点是简捷、快速
```
```
schema://host[:port]/path[?query-string][#anchor]

schema:指定低层使用的协议（例如：http,https,ftp）
host：服务器的ip地址或者域名
port：服务器端口，默认为80
path：访问资源的路径
query-string：发送给http服务器的数据
anchor：锚
```

### 2.2 HTTP协议-请求
```
组成格式：请求行、消息报头、请求正文
```
```
请求行
格式如下：Method Request-URI HTTP-Version CRLF

举例：GET / HTTP/1.1 CRLF
```

#### 2.2.1 请求方法
```
GET 请求获取Request-URI所标识的资源

POST 在Request-URI所标识的资源后附加新的数据

HEAD 请求获取由Request-URI所标识的资源的响应消息报头

PUT 请求服务器存储一个资源，并用Request-URI作为其标识

DELETE 请求服务器删除Request-URI所标识的资源

OPTIONS 请求查询服务器的性能，或者查询与资源相关的选项和需求
```

### 2.3 HTTP协议-响应
```
组成格式：状态行、消息报头、响应正文

状态行
格式如下：HTTP-Version Status-Code Reason-Phrase CRLF

举例如下：HTTP/1.1 200 OK
```

#### 2.3.1 常用状态码
```
# 客户端请求成功
200 OK 

# 客户端请求有语法错误，不能被服务器所理解
400 Bad Request

# 服务器收到请求，但是拒绝提供服务
401 Unauthorized

# 请求资源不存在
404 Not Found

# 服务器发生不可预期的错误
500 Internal Server Error

# 服务器当前不能处理客户端的请求
503 Server Unavailable
```

## 3. 如何设计RESTful API
```
# 1. 资源路径（URI）

在RESTful架构中，每个网址代表一种资源，所以网址中不能有动词，只能有名词。一般来说API中的名词应用使用复数
```
```
举例
举例来说，有一个API提供动物园(zoo)的信息，还包括各种动物和雇员的信息，则它的路径应该设计成下面这样

# 动物园资源
https://api.example.com/v1/zoos

# 动物资源
https://api.example.com/v1/animals

# 雇员资源
https://api.example.com/v1/employees
```

```
# 2. HTTP动词

对于资源的操作(CURD)，由HTTP动词（谓词）表示

GET 从服务器取出资源（一项或多项）

POST 在服务器新建一个资源

PUT 在服务器更新资源（客户端提供改变后的完整资源）

DELETE 从服务器删除资源

PATH 在服务器更新资源（客户端提供改变的属性）
```
```
举例

# 新建一个动物园
POST /zoos

# 获取某个指定动物园的信息
GET /zoos/ID

# 更新某个指定动物园的信息
PUT /zoos/ID

# 删除某个动物园
DELETE /zoos/ID
```
```
# 3. 过滤信息

如果记录数量很多，服务器不可能都将它们返回给用户。API应该提供参数，过滤返回结果
```
```
举例

# 指定返回记录的开始位置
?offset=10

# 指定第几页，以及每页的记录数
?page=2&per_page=100

# 指定返回结果排序，以及排序顺序
?sortby=name&order=asc

# 指定刷选条件
?animal_type_id=1
```
```
# 4. 状态码

服务器向用户返回的状态码和提示信息，使用标准HTTP状态码

# 服务器成功返回用户请求的数据，该操作是幂等的
200 OK

# 新建或修改数据成功
201 CREATED

# 删除数据成功
204 NO CONTENT

# 用户发出的请求有错误，该操作是幂等的
400 BAD REQUEST

# 表示用户没有认证，无法进行当前操作
401 Unauthorized

# 表示用户访问是被禁止的
403 Forbidden

# 当创建一个对象时，发生一个验证错误
422 Unprocesable Entity

# 服务器发生错误，用户将无法判断发出的请求是否成功
500 INTERNAL SERVER ERROR
```
```
# 5. 错误处理

如果状态码是4xx或者5xx，就应该向用户返回出错误信息。一般来说，返回的信息中将error作为键名，出错信息作为键值即可

{
    "error" : "参数错误"
}
```

```
# 6. 返回结果

针对不同操作，服务器向用户返回的结果应该符合以下规范

# 返回资源对象的列表（数组）
GET /collections

# 返回单个资源对象
GET /collections/indentity

# 返回新生成的资源对象
POST /collections

# 返回完整的资源对象
PUT /collections/indentity

# 返回被修改的属性
PATCH /collections/indentity

# 返回一个空文档
DELETE /collections/indentity
```

## 4. 项目实战
### 4.1 确认设计要素
```
# 1. 项目需求

用户登录、注册

文章发表、编辑、管理、列表
```
```
# 2. 确认设计要素

资源路径
/users /articles

HTTP动词
GET POST DELETE PUT

过滤信息
文章的分页刷选

状态码
200 404 422 403

错误处理
输出JSON格式错误信息

返回结果
输出JSON数组或JSON对象
```

### 4.2 数据库设计
```
# 1. 用户表
ID 用户名 密码 注册时间
```
```
# 2. 文章表
文章ID 标题 内容 发表时间 用户ID
```