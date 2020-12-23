# 关于此项目
这个项目主要是基于 laravel5.5 做的一些基础架构封装，封装了一些常用的基础方法，比如上传文件、用户的CRUD、后台管理菜单树形结构且对返回的数据结构做了统一封装  
使得前端所需要的数据结构保持了一致性。

## laravel 已经很优秀了，为什么还要做一些基础封装 ？
laravel 的优秀，确实是毋容置疑的，但是我们还需要针对我们的业务场景对 laravel 做一些简单的封装，便于统一返回给前端的数据结构。这样，不管有多少个团队成员参与开发，我们都能够做到给到前端的数据结构一致，保持了代码的整洁性和规范性。 总之优点还是很多很多的，废话就不多说了，show me your code ！ 直接看代码吧！小老弟！

## 万一不会用，咋办？
本人代码仓库下的 `lara-sample-api` 项目是基于 `laravel6.x` 做的类似封装，完全可以借鉴此用法，且本人代码仓库下的 `lara-shop-api` （商城门户代码） 和 `lara-shop-cms` （商城后台管理代码）均使用类似的基础架构，完全可以参考。  
如果确实还是不知道咋使用，欢迎随时找我唠叨，学海无涯，大家一起成长！

## 注意
目前由于 laravel 框架更新迭代太快，此项目已经不打算更新新功能，只接受 bug 修复。但此项目的骨架功能依然是完整的，且值得一定推敲的，欢迎使用！    

**目前只会考虑不断的去跟着最新的 laravel lts 版本去封装基础骨架，不会跟着最新版本去封装。**