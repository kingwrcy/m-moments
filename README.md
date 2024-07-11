## 极简微博 - 多人版的[极简朋友圈](https://m.mblog.club)

目前功能比较简单

1. 支持markdown语法
2. 支持点赞/评论
3. 支持注册用户

## 部署
1. 新增postgres数据库`m-moments`,执行`schema.sql`文件初始化数据库.
2. 修改根目录下的`docker-compose.yml`文件里的数据库部分,然后使用`docker-compose up -d`一键启动.

## 本地开发

1. 克隆本项目到本地.
2. 提前安装好php和postgres环境,注意php需要安装`pgsql`和`pdo_pgsql`扩展.
3. 执行`composer install`安装依赖.
4. 新建`.env`文件,内容如下:

```shell
DB_HOST=postgres
DB_PORT=5432
DB_NAME=m-moments
DB_USER=postgres
DB_PASSWORD=postgres
#图片上传目录
UPLOAD_DIR=/opt/moments/upload
DEFAULT_USER_AVATAR_CDN=https://gravatar.cooluc.com/avatar/
```

5. 执行`php start.php start`启动服务