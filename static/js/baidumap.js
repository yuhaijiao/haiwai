/**
 * @author 成俊 chengjun@milanoo.com
 */
var map = new BMap.Map("allmap");                        // 创建Map实例
var point = new BMap.Point(104.08517,30.545924);
map.centerAndZoom(point, 12);     // 初始化地图,设置中心点坐标和地图级别
map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
map.enableScrollWheelZoom();                            //启用滚轮放大缩小
map.addControl(new BMap.MapTypeControl());          //添加地图类型控件
map.setCurrentCity("成都");          // 设置地图显示的城市 此项是必须设置的

var marker = new BMap.Marker(point);  // 创建标注
map.addOverlay(marker);              // 将标注添加到地图中
marker.enableDragging();    //可拖拽
{-if $active.position-}

{-/if-}
map.addEventListener("click", function(e){
	  document.getElementById("maplnglat").value = e.point.lng + ", " + e.point.lat;
});