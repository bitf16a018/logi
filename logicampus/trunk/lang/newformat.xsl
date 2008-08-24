<?xml version='1.0'?>
<!DOCTYPE xsl:stylesheet [
<!ENTITY nbsp "&#160;">
]>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                version='1.0'>
				<xsl:output method="xml" indent="yes" encoding="UTF-8"
					doctype-system="http://www.oasis-open.org/committees/xliff/documents/xliff-core-1.1.dtd"
					doctype-public="-//XLIFF//DTD XLIFF//EN" 	
					/>

<xsl:template match="@*|node()">
   <xsl:copy>
      <xsl:apply-templates select="@*|node()"/>
   </xsl:copy>
</xsl:template>

<xsl:template match="target">
	  <xsl:param
		  name="thistext"
		  select="normalize-space(.)"/>

<!--
		-->
	<!--
		-->
	<xsl:element name="target">
		<xsl:attribute name="xml:lang" namespace="xml">es_MX</xsl:attribute>

		<xsl:value-of select="normalize-space(document('messages.es_MX.xml')//message[@id = $thistext])"/>
	</xsl:element>
	<!--
	<xsl:value-of select="$thistext"/>
		-->

	<!--
		New Target
		-->
</xsl:template>
	<!--
		-->
</xsl:stylesheet>
