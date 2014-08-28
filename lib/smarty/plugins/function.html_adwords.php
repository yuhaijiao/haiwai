<?php
use Helper\ResponseUtil as rew;
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {html_adwords} plugin
 *
 * Type:     function
 * Name:     html_adwords
 * Purpose:  尾部seo
 *
 * @version 1.0.0
 * @author Jerry Yang<yang.tao.php@gmail.com>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_html_adwords($params, &$smarty)
{
    $mNav = new \Model\KeyWords();
	$topNav = $mNav->getKeyWords($params['returnNum'],$params['categoryId']);

	if(empty($topNav['resultList']))
	{
		$params['categoryId']=0;
		$topNav = $mNav->getKeyWords($params['returnNum'],0);
	}
	$params_all  =Helper\RequestUtil::getParams();
	$module 		=$params_all->module;
	$action  		=$params_all->action;
	$cid				=$params_all->class;
	$pid				=$params_all->id;
	if($module=='thing' && $action=='item'){		return;	}
	$html_result = '';
	if($topNav['code']==0) {
		$html_result.='<div class="butserv"><div class="other"><dl class="hot">';
		switch(SELLER_LANG){
			case 'en-uk':
				$html_result.=<<<xxx
		<dt>Hot Products</dt>
		<dd>
		<a href="http://www.milanoo.com/Costumes-c934">Costumes</a><br>
		<a href="http://www.milanoo.com/Jewelry-c1100">Jewelry</a><br>
		<a href="http://www.milanoo.com/Swimsuits-c603">Swimsuits</a><br/>
		<a href="http://www.milanoo.com/Prom-Dresses-c394">Prom Dresses</a><br>
		<a href="http://www.milanoo.com/Bridesmaid-Dresses-c393">Bridesmaid Dresses</a><br>
		<a href="http://www.milanoo.com/Wedding-Dresses-c392">Cheap Wedding Dresses</a>
		</dd>
	</dl>
	<dl>
xxx;
				break;
			case 'fr-fr':
			$html_result.=<<<xxx
		<dt>Hot Products</dt>
		<dd>
		<a href="http://www.milanoo.com/fr/Costumes-Cosplay-c300">Costumes Cosplay</a><br />
        <a href="http://www.milanoo.com/fr/Robes-de-mariée-c392">Robes de mariée</a><br />
        <a href="http://www.milanoo.com/fr/Robes-Lolita-c635">Robes Lolita</a><br />
        <a href="http://www.milanoo.com/fr/Robes-de-cocktail-c565">Robes de cocktail</a><br />
        <a href="http://www.milanoo.com/fr/Vêtements-de-Lolita-c634">Vêtements de Lolita</a><br />
        <a href="http://www.milanoo.com/fr/Robes-de-cérémonie-mariage-c829">Robes de cérémonie mariage</a>
		</dd>
	</dl>
	<dl>
xxx;
				break;
			case 'ja-jp':
			$html_result.=<<<xxx
		<dt>人気のカテゴリ</dt>
		<dd>
		<a href="http://www.milanoo.com/jp/c391">ウェディングドレス</a><br />
       <a href="http://www.milanoo.com/jp/c564">フォーマル ドレス</a><br />
       <a href="http://www.milanoo.com/jp/c1140">インナー</a><br />
       <a href="http://www.milanoo.com/jp/c539">ワンピース</a><br />
       <a href="http://www.milanoo.com/jp/c566">バッグ</a><br />
	   <a href="http://www.milanoo.com/jp/c766">シューズ</a><br />
	   <a href="http://www.milanoo.com/jp/c1058">インテリア</a>
		</dd>
	</dl>
	<dl>
xxx;
				break;
			case 'es-sp':
			$html_result.=<<<xxx
		<dt>Productos Más Vendidos</dt>
		<dd>
		<a href="http://www.milanoo.com/es/c392">Vestidos de Novia</a><br />
        <a href="http://www.milanoo.com/es/c574">Vestidos de Noche</a><br />
        <a href="http://www.milanoo.com/es/c535">Ropa de Mujer</a><br />
        <a href="http://www.milanoo.com/es/c766">Zapatos de Moda</a><br />
        <a href="http://www.milanoo.com/es/c1025">Disfraces de Cine & TV</a><br />
        <a href="http://www.milanoo.com/es/c1155">Ropa de Hombre</a>
		</dd>
	</dl>
	<dl>
xxx;
				break;
			case 'de-ge':
			$html_result.=<<<xxx
		<dt>Heiße Produkte</dt>
		<dd>
		<a href="http://www.milanoo.com/de/c392">brautkleider</a><br />
        <a href="http://www.milanoo.com/de/c574">abendkleider</a><br />
        <a href="http://www.milanoo.com/de/c934">kostüm</a><br />
        <a href="http://www.milanoo.com/de/c566">handtaschen</a><br />
        <a href="http://www.milanoo.com/de/c766">damenschuhe</a><br />
        <a href="http://www.milanoo.com/de/c792">perücken</a><br />
        <a href="http://www.milanoo.com/de/c606">bikini</a>
		</dd>
	</dl>
	<dl>
xxx;
				break;
			case 'it-it':
			$html_result.=<<<xxx
		<dt>Articoli più Venduti</dt>
		<dd>
		<a href="http://www.milanoo.com/it/c300">Cosplay</a><br />
        <a href="http://www.milanoo.com/it/c392">Abiti da Sposa</a><br />        
        <a href="http://www.milanoo.com/it/c1399">Scarpe</a><br />
        <a href="http://www.milanoo.com/it/c314">Catsuit & Zentai</a><br />
        <a href="http://www.milanoo.com/it/c1140">Intimo Sexy</a><br />
        <a href="http://www.milanoo.com/it/c603">Costumi da Bagno</a><br />
        <a href="http://www.milanoo.com/it/c189">Mascotte</a>
		</dd>
	</dl>
	<dl>
xxx;
				break;
			case 'ru-ru':
			$html_result.=<<<xxx
		<dt>Горячие товары</dt>
		<dd>
		<a href="http://www.milanoo.com/ru/c934">Косплей костюмы</a><br />
        <a href="http://www.milanoo.com/ru/c1100">Ювелирные изделия</a><br />
        <a href="http://www.milanoo.com/ru/c535">Женская одежда</a><br />
        <a href="http://www.milanoo.com/ru/c1155">мужская одежда</a><br />
        <a href="http://www.milanoo.com/ru/c392">Свадебные платья</a><br />
        <a href="http://www.milanoo.com/ru/c1140">Женское нижнее белье</a><br />
        <a href="http://www.milanoo.com/ru/c574">Вечерние платья</a>
		</dd>
	</dl>
	<dl>
xxx;
				break;
			default:break;
		}
		if(SELLER_LANG!='it-it'){//意大利语站不存在该模块
			if( $smarty->_tpl_vars['search']!=1 && $module=='thing' && $action=='glist'){//列表页
				$html_result .= '<dt>'.\LangPack::$items['related_Categories'].'</dt><dd>';
				$num=0;
				if(!empty($smarty->_tpl_vars['productCategory'])){
					foreach($smarty->_tpl_vars['productCategory'] as $cat){
						$num++;
						if($num<=8){
							$keywords_temp[]='<a class="pivot_link" href="'.rew::rewrite(array('url'=>'?module=thing&action=glist&class='.$cat['categoryId'],'isxs'=>'no','seo'=>$cat['categoryName'])).'">'.stripslashes($cat['categoryName']).'</a>';
						}else{
							break;
						}
					}
				}else if(!empty($smarty->_tpl_vars['result']['productCategory']['childrenList'])){
					foreach($smarty->_tpl_vars['result']['productCategory']['childrenList'] as $cat){
						$num++;
						if($num<=8){
							$keywords_temp[]='<a class="pivot_link" href="'.rew::rewrite(array('url'=>'?module=thing&action=glist&class='.$cat['categoryId'],'isxs'=>'no','seo'=>$cat['categoryName'])).'">'.stripslashes($cat['categoryName']).'</a>';
						}else{
							break;
						}
					}
				}
				if(!empty($keywords_temp)){
					$keywords_temp=array_slice($keywords_temp,0,8);
					$keywords_temp=implode(', ',$keywords_temp);
				}else{
					$keywords_temp='';
				}
				$html_result .=$keywords_temp;
			}else{//除列表页外的搜索页，首页，和其他2.0的页面
				$html_result .= '<dt>'.\LangPack::$items['index_TOPSearchs'].'</dt><dd>';
				
				switch(SELLER_LANG){
					case 'en-uk':
						$html_result .=<<<xxxx
				<a href="http://www.milanoo.com/Wedding-Dresses-c392" class="pivot_link" title='Cheap Wedding Dresses'>Cheap Wedding Dresses</a>,
				<a class="pivot_link" title='Bridesmaid Dresses' href="http://www.milanoo.com/Bridesmaid-Dresses-c393" >Bridesmaid Dresses</a>,
				<a class="pivot_link" title='Evening Dresses' href="http://www.milanoo.com/Evening-Dresses-c574" >Evening Dresses</a>,
				<a class="pivot_link" title='Cocktail Dresses' href="http://www.milanoo.com/Cocktail-Dresses-c565" >Cocktail Dresses</a>,
				<a class="pivot_link" title='Homecoming Dresses' href="http://www.milanoo.com/Homecoming-Dresses-c826" >Homecoming Dresses</a>,
				<a class="pivot_link" title='Lolita dresses' href="http://www.milanoo.com/Lolita-Dresses-c635" >Lolita dresses</a>,
				<a class="pivot_link" title='prom dresses' href="http://www.milanoo.com/Prom-Dresses-c394" >prom dresses</a>,
				<a class="pivot_link" title='cosplay costumes' href="http://www.milanoo.com/Cosplay-Costumes-c300" >cosplay costumes</a>,
				<a class="pivot_link" title='bedding set' href="http://www.milanoo.com/Bedding-Sets-c1059" >bedding set</a>,
				<a class="pivot_link" title='Boots' href="http://www.milanoo.com/Boots-c628" >Boots</a>,
				<a class="pivot_link" title='Hand Bags' href="http://www.milanoo.com/Handbags-c566" >Hand Bags</a>,
				<a class="pivot_link" title='swimsuits' href="http://www.milanoo.com/Swimsuits-c603" >swimsuits</a>,
				<a class="pivot_link" title='Heels' href="http://www.milanoo.com/Heels-c1011" >Heels</a>
xxxx;
						break;
					case 'fr-fr':
					$html_result .=<<<xxxx
				<a class="pivot_link" title='robes de demoiselle d'honneur adulte' href="http://www.milanoo.com/fr/Robes-demoiselle-dhonneur-c393" >robes de demoiselle d'honneur adulte</a>,
				<a class="pivot_link" title='Robes de mariée pas chères' href="http://www.milanoo.com/fr/Robes-de-mari-%EF%BF%BDe-c392" >Robes de mariée pas chères</a>,
				<a class="pivot_link" title='Cosplay Naruto' href="http://www.milanoo.com/fr/Naruto-c488" >Cosplay Naruto</a>,
				<a class="pivot_link" title='Zentai' href="http://www.milanoo.com/fr/Naruto-c488" >Zentai</a>,
				<a class="pivot_link" title='Robes Lolita pas chères' href="http://www.milanoo.com/fr/Catsuit-Zenta-%EF%BF%BD-c314" >Robes Lolita pas chères</a>,
				<a class="pivot_link" title='Corsets' href="http://www.milanoo.com/fr/Robes-Lolita-c635" >Corsets</a>,
				<a class="pivot_link" title='Talons hauts' href="http://www.milanoo.com/fr/Talons-Hauts-c1011" >Talons hauts</a>,
				<a class="pivot_link" title='Perruque Fashion pas chère' href="http://www.milanoo.com/fr/Perruques-Fashion-c792" >Perruque Fashion pas chère</a>,
				<a class="pivot_link" title='Vêtements pour chien' href="http://www.milanoo.com/fr/Fournitures-danimal-domestique-c148" >Vêtements pour chien</a>,
				<a class="pivot_link" title='Costumes Homme' href="http://www.milanoo.com/fr/Costumes-c1169" >Costumes Homme</a>
xxxx;
						
						break;
					case 'ja-jp':	
						$html_result .=<<<xxxx
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c392" title='ウェディングドレス'>ウェディングドレス</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c300" title='コスプレ'>コスプレ</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c634" title='ロリィタ'>ロリィタ</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c314" title='全身タイツ'>全身タイツ</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c535" title='レディース'>レディース</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c1155" title='メンズ'>メンズ</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c1399" title='シューズ'>シューズ</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c1281" title='バッグ＆アクセ'>バッグ＆アクセ</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c149" title='スポーツウエア'>スポーツウエア</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/jp/c1058" title='インテリア'>インテリア</a>
				
xxxx;
						break;
					case 'es-sp':
						$html_result .=<<<xxxx
				<a class="pivot_link"  href="http://www.milanoo.com/es/c392" title='vestidos de novia al mejor precio'>vestidos de novia al mejor precio</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/es/c564" title='vestidos de fiesta'>vestidos de fiesta</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/es/c2186" title='cosplay'>cosplay</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/es/c934" title='disfraces'>disfraces</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/es/c542" title='moda mujer'>moda mujer</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/es/c1156" title='moda hombre'>moda hombre</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/es/c766" title='zapatos baratos'>zapatos baratos</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/es/c2196" title='bolsos'>bolsos</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/es/c603" title='ropa deportiva'>ropa deportiva</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/es/c1346" title='ropa de cama'>ropa de cama</a>
xxxx;
						break;
					case 'de-ge':
						$html_result .=<<<xxxx
				<a class="pivot_link"  href="http://www.milanoo.com/de/c934" title='Kostüm'>Kostüm</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/de/c300" title='Cosplay'>Cosplay</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/de/c392" title='Brautkleid'>Brautkleid</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/de/c829" title='Abendkleid'>Abendkleid</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/de/c634" title='Lolita'>Lolita</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/de/c314" title='Zentai'>Zentai</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/de/c1399" title='Modeschuhe'>Modeschuhe</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/de/c535" title='Damenmode'>Damenmode</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/de/c1155" title='Herrenmode'>Herrenmode</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/de/c1281" title='Tasche'>Tasche</a>
xxxx;
						break;
					case 'ru-ru':
						$html_result .=<<<xxxx
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c356" title='Корсеты'>Корсеты</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c488" title='Наруто косплей'>Наруто косплей</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c603" title='Купальники'>Купальники</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c566" title='Женские сумки'>Женские сумки</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c301" title='Парики для косплея'>Парики для косплея</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c634" title='Лолита одежда'>Лолита одежда</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c628" title='Сапоги сапоги'>Сапоги сапоги</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c1346" title='Постельное белье'>Постельное белье</a>,
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c1074" title='Мужские рубашки '>Мужские рубашки </a>,
				<a class="pivot_link"  href="http://www.milanoo.com/ru/c782" title='Свадебные аксессуары '>Свадебные аксессуары </a>
xxxx;
						break;
					default:break;
				}
			}
		}
		
		switch(SELLER_LANG){
			case 'en-uk':
				$html_result .='<br><a href="http://www.milanoo.com/producttags/A/" class="underline">More popular searches &gt;&gt;</a>
				</dd></dl>
				<dl><dt>Trustful</dt><dd>';
				break;
			case 'fr-fr':
				$html_result .='<br><a class="underline" title="Les Recherches Plus Populaires" href="http://www.milanoo.com/producttags/A/">Les Recherches Plus Populaires &gt;&gt;</a></dd></dl>
				<dl><dt>Boutique de Confiance</dt><dd>';
				break;
			case 'ja-jp':	
				$html_result .='</dl><dl><dt>Milanoo.comについて</dt><dd>';
				break;
			case 'es-sp':
				$html_result .='<br><a class="underline" title="More popular searches" href="http://www.milanoo.com/producttags/A/">Más búsquedas populares… &gt;&gt;</a> </dd></dl>
				<dl><dt>Confianza</dt><dd>';
				break;
			case 'de-ge':
				$html_result .='<br><a class="underline" title="More popular searches" href="http://www.milanoo.com/producttags/A/">More popular searches &gt;&gt;</a></dd></dl>
				<dl><dt>Vertrauensvoll</dt><dd> ';
				break;
			case 'it-it':		
				$html_result .='</dl><dl><dt>Operazione Trasparenza</dt><dd>';
				break;
			case 'ru-ru':
				$html_result .='<br><a class="underline" title="Поиск продукции по тэгам" href="http://www.milanoo.com/producttags/A/">Поиск продукции по тэгам &gt;&gt;</a></dd></dl>
				<dl><dt>Надёжный магазин</dt><dd> ';
				break;
			case 'pt-pt':	break;
			case 'zh-hk':	break;
			case 'zh-cn':	break;
			case 'ar-ar':	break;
			default:break;
		}
		
		if($module=='thing' && $action=='glist' && $cid){
		
			$cateinfo_obj = new \Model\Navigator(); 
			$cateinfo = $cateinfo_obj->getNav($cid,'0:0:0');
		
			if($cateinfo['selfCategory']['categoryLogoAd']){
				$html_result.=$cateinfo['selfCategory']['categoryLogoAd'];
			}else{
				$categoryName=stripslashes($cateinfo['selfCategory']['categoryName']);
				if($smarty->_tpl_vars['propertyUrlArray'] && $smarty->_tpl_vars['seo_attrs']){//属性筛选列表页
					$attrs_plus_category=strtolower($smarty->_tpl_vars['seo_attrs'].' '.$categoryName);
					switch(SELLER_LANG){
						case 'en-uk':
							$html_result.='Buy '.$attrs_plus_category.' with the highest quality from Milanoo.com. Find discount '.$attrs_plus_category.' in the latest style and make a fashion statement!';
							break;
						case 'fr-fr':
							$html_result.='Achète '.$attrs_plus_category.' de haute qualité sur Milanoo.com Profite des réductions sur les derniers '.$attrs_plus_category.' à la mode et reste Fashion';
							break;
						case 'ja-jp':
							$html_result.='GETしよう！　'.$attrs_plus_category.'　ハイクオリティをMilanoo.comから
ベストプライスで見つけよう！　'.$attrs_plus_category.'　最新のスタイルで極めるファッション';
							break;
						case 'es-sp':
							$html_result.='Compra '.$attrs_plus_category.' de alta calidad de Milanoo.com. ¡Encuentra el mejor descuento de '.$attrs_plus_category.' de la última moda y crea nuevos look infalibles a precios sensacionales!';
							break;
						case 'de-ge':
							$html_result.='Hochwertige '.$attrs_plus_category.' aus Milanoo kaufen. '.$attrs_plus_category.' mit Rabatt in dem neusten Stil bekommen und immer im Trend bleiben.';
							break;
						case 'it-it':
							$html_result.="Acquista . ".$attrs_plus_category.". di alta qualita' su Milanoo.com Grandi sconti ".$attrs_plus_category." in tantissimi stili!";
							break;
						case 'ru-ru':
							$html_result.='Купите '.$attrs_plus_category.' высоко-качества в Milanoo.com, наймете скидку '.$attrs_plus_category.'&nbsp;&nbsp;в моде и сделаете констатацию о моде!';
							break;
						default:break;
					}
				}else{
					switch(SELLER_LANG){
						case 'en-uk':
							$html_result.='	Buy cheap '.$categoryName.' with the highest quality from Milanoo.com. Find discount '.$categoryName.' in the latest style and create a fashion look. Shop online now!';
							break;
						case 'fr-fr':
							$html_result.='Achats en ligne pour '.$categoryName." d'une large sélection de vêtements et accessoires à prix incroyablement bon marché avec la qualité garantie. En entrant dans des styles divers et des designs(conceptions), notre collection ".$categoryName." est parfaite pour vous sans sacrifier la qualité. Achetez maintenant et économisez sur ".$categoryName.".";
							break;
						case 'ja-jp':
							$html_result.='ミラノーでご購入いただいた高品質で低価格の'.$categoryName.'，割引特価の新商品 '.$categoryName.'買って納得、もっとオシャレになれる服。さあミラノーでネットショッピング！';
							break;
						case 'es-sp':
							$html_result.='Online Tienda para '.$categoryName.' tiene una gran selección de ropa & accesorios a precios increíblemente baratos con garantía de calidad. Viene en varios estilos y diseños, nuestra selección de '.$categoryName.' es perfecta para añadir estilo sin sacrificar la calidad. Compre ahora y ahorre en '.$categoryName.'.';
							break;
						case 'de-ge':
							$html_result.='Online Shop für '.$categoryName.' aus einer großen Auswahl an Kleidung und Accessories in günstigen Preisen mit garantierter Qualität. Unser '.$categoryName.' ist perfekt für Dekoration Ihres Kleiderschranks. Kaufen jetzt und auf '.$categoryName.' speichern!';
							break;
						case 'it-it':
							$html_result.='Acquista online '.$categoryName.' da una vasta selezione di abbigliamento & accessori ad un incredibile prezzo. Qualità garantita. La nostra selezione di '.$categoryName.' è molto varia e alla moda, perfetta per tutti gli stili. Acquista ora e risparmia su '.$categoryName.'.';
							break;
						case 'ru-ru':
							$html_result.='В интернет-магазине вам можно купить большой ассортимент '.$categoryName.' одежды и аксессуаров по невероятно низким ценам с гарантированным качеством. Чем больше Вы купите, тем больше будет скидка. '.$categoryName.' придадет Вам загадочность и шарм.';
							break;
						default:break;
					}
				}
				
			}
		}else if($module=='index' && $action=='index'){
			$html_result.=\LangPack::$items['index_reliAppa'];
		}else{
				switch(SELLER_LANG){
					case 'en-uk':
						$html_result.='	Reliable and professional China apparel wholesale website where you can buy cheap wholesale costume products and dropship them anywhere in the world!';
						break;
					case 'fr-fr':
						$html_result.='Trouvez les meilleurs offres: Vêtements de mariage, Robes pour occasions spéciales, Vêtements décontractés, Chaussures, Sacs à main et Accessoires de maison sur Milanoo.com.';
						break;
					case 'ja-jp':
						$html_result.='Milanoo.comは、アパレルの卸売販売を行うオンライン・ショッピング・サイトです。高品質で豊富なラインナップを、すべて卸売価格にてご提供しております。ご注文にはスピーディに対応、ただちに発送いたします。<br />是非、Milanooでのショッピングをお楽しみください。';
						break;
					case 'es-sp':
						$html_result.='	Encuentra los mejores vestidos de novia, vestidos para occasion especial, ropa informal, bolsos en Milanoo.com';
						break;
					case 'de-ge':
						$html_result.='Finden Sie hier die Bestseller der Gesellschaftsbekleidung , Freizeitbekleidung und vielfältigen Accessories für allerlei Events auf Milanoo.com.';
						break;
					case 'it-it':
						$html_result.=!empty($tplar['index_reliAppa'])?$tplar['index_reliAppa']:'Cerca tra le migliori offerte su abiti matrimonio, occasioni speciali, abbigliamento casual, scarpe e articoli per la casa Milanoo.com';
						break;
					case 'ru-ru':
						$html_result.='	Лучшие распродажи свадебных нарядов, платьев для особых случаев, повседневной одежды, сумок и товаров для дома в Milanoo.com';
						break;
					default:break;
				}
		}
		$html_result .='</dd></dl></div>';
		if(SELLER_LANG=='en-uk'){
			$html_result .=<<<yyy
					
				<div class="serve">
					<dl>
						<dt>Why Shop With Us</dt>
						<dd>
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/7-day-Policy-for-Return-and-15-day-Policy-for-Exchange-All-Milanoo-Products-Do-You-Have-A-Guarantee-or-Warranty-module-index-id-6.html">7-day Policy for Return</a><br />
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/Payment-Methods-module-index-id-19.html">Pay with Credit Card</a><br />
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/Payment-Methods-module-index-id-19.html">Pay with PayPal</a><br />
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/Could-you-introduce-briefly-EMSUPSDHLTNTand-Sagawa-Express--module-index-id-75.html">Fast shipping & delivery</a>
						</dd>
					</dl>
					<dl>
						<dt>What's In Store</dt>
						<dd>
							<a target="_blank" href="http://www.milanoo.com/Wedding-Apparel-c391">Wedding Apparel</a><br />
							<a target="_blank" href="http://www.milanoo.com/Costumes-c934">Costumes</a><br />
							<a target="_blank" href="http://www.milanoo.com/Womens-Clothing-c535">Clothing</a><br />
							<a target="_blank" href="http://www.milanoo.com/Shoes-c1399">Shoes</a>
						</dd>
					</dl>
					<dl>
						<dt>How Can We Help</dt>
						<dd>
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/How-to-Make-an-Order-from-Milanoo-module-index-id-1.html">Track Order</a><br />
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/index-act-center.html">Help Center</a><br />
							<a target="_blank" rel="nofollow" href="https://www.milanoo.com/member/">My account</a><br />
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/Submit-a-question-module-index.html">Contact Milanoo</a>
						</dd>
					</dl>
					<dl>
						<dt>Further Information</dt>
						<dd>
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/About-Milanoo-module-index-id-41.html#sid=41">About us</a><br />
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/Can-You-Show-Me-How-You-Calculate-Shipping-module-index-id-38.html">Delivery costs</a><br />
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/Privacy-Policy-module-index-id-72.html">Security</a><br />
							<a target="_blank" rel="nofollow" href="http://www.milanoo.com/help/About-Milanoo-Affiliates-Programme-module-index-id-67.html">Affiliate Program</a>
						</dd>
					</dl>
				</div>
yyy;
		}
		$html_result .='</div>';
	}
	//die(strlen($html_result));
    return $html_result;
}
?>