<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="height:400px"></div>
<!-- ECharts单文件引入 -->
<script src="http://echarts.baidu.com/build/dist/echarts.js"></script>
<script src="/js/exloper.js"></script>
<script type="text/javascript">
    // 路径配置
    require.config({
        paths: {
            echarts: 'http://echarts.baidu.com/build/dist'
        }
    });

    // 使用
    require(
        [
            'echarts',
            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
            '/js/echarts/theme/macarons'  ,//+ hash.replace('-en', ''),
            'echarts/chart/line',
           // 'echarts/chart/bar',
            'echarts/chart/scatter',
            'echarts/chart/k',
            'echarts/chart/pie',
            'echarts/chart/radar',
            'echarts/chart/force',
            'echarts/chart/chord',
            'echarts/chart/gauge',
            'echarts/chart/funnel',
            'echarts/chart/eventRiver',
            'echarts/chart/venn',
            'echarts/chart/treemap',
            'echarts/chart/tree',
            'echarts/chart/wordCloud',
            'echarts/chart/heatmap',
           // needMap() ? 'echarts/chart/map' : 'echarts'
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main'));



            var option = {
                title : {
                    text: '未来一周气温变化',
                    subtext: '纯属虚构'
                },
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['最高气温']
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        data : ['周一','周二','周三','周四','周五','周六','周日']
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLabel : {
                            formatter: '{value} °C'
                        }
                    }
                ],
                series : [
                    //可以放置多条数据
                    {
                        name:'最高气温',
                        type:'line',
                        data:[11, 11, 15, 13, 12, 13, 10],
                        markPoint : {
                            data : [
                                {type : 'max', name: 'max'},
                                {type : 'min', name: 'min'}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name: 'average'}
                            ]
                        }
                    }
                ]
            };

            //option.title.text="标题";
            //option.title.subtext="详情说明";
            //option.legend.data="横线颜色文字";//数据名称
            //option.xAxis[0].data=[,,,,];//x轴数据
            //option.yAxis[0].axisLabel.formatter='{value} °C';//格式化Y轴单位

            //option.series[0].data=[,,,,];//y轴数据
            //option.series[0].name='最高气温';//数据名称

            var url =GetQueryString("url");
            url = url.split("/");

            if(url[2]){
                url =url[2];
            }else{
                url =url[0];
            }
            $.ajax({
                type: "GET",
                url: "/admin/Visit/GetVisitChartData",
                data: {url:url},
                dataType: "json",
                success: function(data){

                   option.title.text=data.title;
                   option.title.subtext=data.subtext;

                   option.xAxis[0].data=data.xAxis;//x轴数据
                   option.yAxis[0].axisLabel.formatter=data.formatter;//格式化Y轴单位

                   option.series[0].data=data.series;//y轴数据
                   option.series[0].name=data.name;//数据名称

                    option.legend.data=[data.name];
                    console.log(option);
                    // 为echarts对象加载数据
                    myChart.setOption(option);
                }
            });


        }
    );
</script>