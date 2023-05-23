<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
        <html>
            <head>
                <style>
          table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
          }
                </style>
            </head>
            <body>
                <h1>Fakulta</h1>
                <xsl:apply-templates select="fakulta/katedra"/>
            </body>
        </html>
    </xsl:template>

    <xsl:template match="katedra">
        <h2>Katedra: <xsl:value-of select="@zkratka_katedry"/>
        </h2>
        <xsl:if test="@webové_stránky">
            <p>Webové stránky: <a href="{@webové_stránky}" target="_blank">
                <xsl:value-of select="@webové_stránky"/>
            </a>
        </p>
    </xsl:if>
    <h3>Vedoucí: <xsl:value-of select="vedoucí/jméno"/>
    </h3>
    <p>Telefon: <xsl:value-of select="vedoucí/telefon"/>
    </p>
    <p>Email: <xsl:value-of select="vedoucí/email"/>
    </p>
    <h3>Zaměstnanci:</h3>
    <table>
        <tr>
            <th>Jméno</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Pozice</th>
        </tr>
        <xsl:apply-templates select="zaměstnanci/zaměstnanec"/>
    </table>
    <h3>Předměty:</h3>
    <table>
        <tr>
            <th>Zkratka</th>
            <th>Název</th>
            <th>Typ</th>
            <th>Popis</th>
        </tr>
        <xsl:apply-templates select="předměty/předmět"/>
    </table>
    <br/>
</xsl:template>

<xsl:template match="zaměstnanec">
    <tr>
        <td>
            <xsl:value-of select="jméno"/>
        </td>
        <td>
            <xsl:value-of select="email"/>
        </td>
        <td>
            <xsl:value-of select="telefon"/>
        </td>
        <td>
            <xsl:value-of select="name(pozice/*)"/>
        </td>
    </tr>
</xsl:template>

<xsl:template match="předmět">
    <tr>
        <td>
            <xsl:value-of select="@zkratka"/>
        </td>
        <td>
            <xsl:value-of select="název"/>
        </td>
        <td>
            <xsl:value-of select="@typ"/>
        </td>
        <td>
            <xsl:value-of select="popis"/>
        </td>
    </tr>
</xsl:template>

</xsl:stylesheet>
