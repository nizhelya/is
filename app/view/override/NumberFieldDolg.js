Ext.define('yis.view.override.NumberFieldDolg', {
    override: 'yis.view.NumberFieldDolg',
     forcePrecision : true,
    valueToRaw: function(value) {
        var me = this,
            decimalSeparator = me.decimalSeparator;
        value = me.parseValue(value);
        value = me.fixPrecision(value);
        value = Ext.isNumber(value) ? value : parseFloat(String(value).replace(decimalSeparator, '.'));
        
        if (isNaN(value))
        {
            value = '';
        } else {
            value = me.forcePrecision ? value.toFixed(me.decimalPrecision) : parseFloat(value);
            value = String(value).replace(".", decimalSeparator);
        }
        return value;
    }
});