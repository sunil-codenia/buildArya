import re

file_path = "/home/codenia/rsg/web panel/rsgeotechindia.com/app/Http/helpers.php"
with open(file_path, "r") as f:
    content = f.read()

def inject_dummy_point(func_body, identifier):
    if "return $formattedData;" in func_body:
        replacement = """
    if (count($formattedData) === 1) {
        $dummy = $formattedData[0];
        foreach($dummy as $key => $val) {
            if ($key !== 'period' && $key !== 'y') {
                $dummy[$key] = 0;
            }
        }
        if (isset($dummy['period'])) { $dummy['period'] = 'Start'; }
        if (isset($dummy['y'])) { $dummy['y'] = 'Start'; }
        array_unshift($formattedData, $dummy);
    }
    return $formattedData;"""
        return func_body.replace("return $formattedData;", replacement)

    if "return $result;" in func_body:
        replacement = """
    if (count($result) === 1) {
        $dummy = $result[0];
        foreach($dummy as $key => $val) {
            if ($key !== 'period' && $key !== 'y') {
                $dummy[$key] = 0;
            }
        }
        if (isset($dummy['period'])) { $dummy['period'] = 'Start'; }
        if (isset($dummy['y'])) { $dummy['y'] = 'Start'; }
        array_unshift($result, $dummy);
    }
    return $result;"""
        return func_body.replace("return $result;", replacement)

    if "return $data;" in func_body:
        replacement = """
    if (count($data) === 1) {
        $dummy = (array) $data[0];
        foreach($dummy as $key => $val) {
            if ($key !== 'period' && $key !== 'y') {
                $dummy[$key] = 0;
            }
        }
        if (isset($dummy['period'])) { $dummy['period'] = 'Start'; }
        if (isset($dummy['y'])) { $dummy['y'] = 'Start'; }
        
        $new_data = [];
        $new_data[] = (object) $dummy;
        foreach($data as $d) { $new_data[] = $d; }
        return $new_data;
    }
    return $data;"""
        return func_body.replace("return $data;", replacement)
        
    return func_body

functions_to_fix = [
    "get_monthlyExpensesFormatted_chart_widget",
    "get_company_monthlyExpensesFormatted_chart_widget",
    "get_site_bills_area_chart",
    "get_company_site_bills_area_chart",
    "get_site_sales_invoices_chart_widget",
    "get_company_sales_invoices_chart_widget",
    "get_payment_voucher_chart_widget",
    "get_company_payment_voucher_chart_widget"
]

new_content = content
for func in functions_to_fix:
    pattern = r'(function ' + func + r'\b[^\{]*\{)(.*?\n\})'
    match = re.search(pattern, new_content, re.DOTALL)
    if match:
        original_body = match.group(2)
        new_body = inject_dummy_point(original_body, func)
        new_content = new_content.replace(match.group(0), match.group(1) + new_body)

with open(file_path, "w") as f:
    f.write(new_content)
    
print("Helpers updated!")

for blade in ["dashboard.blade.php", "company_dashboard.blade.php"]:
    blade_path = f"/home/codenia/rsg/web panel/rsgeotechindia.com/resources/views/layouts/{blade}"
    with open(blade_path, "r") as f:
        html = f.read()

    # Add parseTime: false if it's missing (replace "labels: labels," with "labels: labels, parseTime: false,")
    # Actually just add it next to xkey to avoid duplicating. Or just replace labels: labels,
    
    html = re.sub(r'(labels:\s*labels,)(\s*(?!parseTime))', r'\1\n                    parseTime: false,\2', html)
    
    with open(blade_path, "w") as f:
        f.write(html)
        
print("Blades updated!")
