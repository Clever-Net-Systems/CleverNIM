<?php
 
class ClientScript extends CClientScript {
	/**
	 * Inserts the scripts in the head section.
	 * @param string $output the output to be inserted with scripts.
	 */
	public function renderHead(&$output)
	{
		$html='';
		foreach($this->metaTags as $meta)
			$html.=CHtml::metaTag($meta['content'],null,null,$meta)."\n";
		foreach($this->linkTags as $link)
			$html.=CHtml::linkTag(null,null,null,null,$link)."\n";
		foreach($this->cssFiles as $url=>$media)
			$html.=CHtml::cssFile($url,$media)."\n";
		foreach($this->css as $css)
			$html.=CHtml::css($css[0],$css[1])."\n";
		if($this->enableJavaScript)
		{
			if(isset($this->scriptFiles[self::POS_HEAD]))
			{
				foreach($this->scriptFiles[self::POS_HEAD] as $scriptFile)
					$html.=CHtml::scriptFile($scriptFile)."\n";
			}

			if(isset($this->scripts[self::POS_HEAD]))
				$html.=CHtml::script(implode("\n",$this->scripts[self::POS_HEAD]))."\n";
		}

		if($html!=='')
		{
			$count=0;
			/*
			 * The line below ensures that everything registered by Yii at POS_HEAD goes just before
			 * the head ending (</head>). This way, Yii styles and scripts will be rendered *BELOW* and
			 * *AFTER* those of Wordpress.
			 * 
			 * The original line in parent reads:
			 * $output = preg_replace('/(<title\b[^>]*>|<\\/head\s*>)/is', '<###head###>$1', $output, 1, $count);
			 * 
			 */
			$output = preg_replace('/(<\\/head\s*>)/is', '<###head###>$1', $output, 1, $count);
			//$output=preg_replace('/(<title\b[^>]*>|<\\/head\s*>)/is','<###head###>$1',$output,1,$count);
			if($count)
				$output=str_replace('<###head###>',$html,$output);
			else
				$output=$html.$output;
		}
	}
}
