<?php
/**
 * @package limba.generators.admin.components.headers
 * @author  Ludovic Reenaers
 * @since 04 fev. 2011
 * @link http://code.google.com/p/limba
 */
class AdminBannerGenerator extends Generator{
	function setUp(){
		$this->content = '<table style="padding: 0px; margin: 10px 0px 10px 0px; width: 100%" cellpadding="0" cellspacing="0">'."\n";
		$this->content .= '  <tbody>'."\n";
		$this->content .= '    <tr style="height: 58px;">'."\n";
		$this->content .= '      <td id="plogo">'."\n";
		$this->content .= '        <a href="/admin.php?/homepage/show/"> <img src="/img/limba/logo.png" alt="Limba" title="Limba"/> </a>'."\n";
		$this->content .= '      </td>'."\n";
		$this->content .= '      <td style="padding-left: 0.5em">'."\n";
		$this->content .= '        <div id="pname"><a href="/admin.php?/homepage/show/">limba</a></div>'."\n";
		$this->content .= '        <div id="psum"><a id="project_summary_link" href="/admin.php?/homepage/show/">Limba Integrates &amp; Models Business Artifacts</a></div>'."\n";
		$this->content .= '      </td>'."\n";
		$this->content .= '      <td style="white-space: nowrap; text-align: right; vertical-align: bottom;">'."\n";
		$this->content .= '			<form action="/admin.php?/search/fulltext/"><input size="30" name="q" value="" type="text"> <input type="submit"	name="projectsearch" value="Search projects"></form>'."\n";
		$this->content .= '      </td>'."\n";
		$this->content .= '    </tr>'."\n";
		$this->content .= '  </tbody>'."\n";
		$this->content .= '</table>'."\n";
	}
}