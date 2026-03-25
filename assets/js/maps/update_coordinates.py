#!/usr/bin/env python3
"""
Script to update Morocco and Western Sahara coordinates in the Africa map data
with the specified arc values.
"""

import json
import re

def update_map_coordinates():
    # Read the original JavaScript file
    with open('africa.js', 'r') as f:
        content = f.read()
    
    # Extract the JSON part
    json_match = re.search(r'Highcharts\.maps\["custom/africa"\] = (.+);', content)
    if not json_match:
        print("Could not extract JSON from africa.js")
        return
    
    json_str = json_match.group(1)
    data = json.loads(json_str)
    
    # Find and update Morocco (MA)
    for feature in data['features']:
        if feature['id'] == 'MA':
            print("Updating Morocco (MA) coordinates...")
            # Convert your arc values [225, -99] to coordinate format
            # Note: This is a simplified conversion - you may need to adjust based on your coordinate system
            new_coords = [225, -99]  # Your specified arc values
            feature['geometry']['coordinates'][0][0] = new_coords
            print(f"Morocco coordinates updated to: {new_coords}")
            break
    
    # Find and update Western Sahara (EH)
    for feature in data['features']:
        if feature['id'] == 'EH':
            print("Updating Western Sahara (EH) coordinates...")
            # Convert your arc values [171, 172, -98, -173] to coordinate format
            # Note: This is a simplified conversion - you may need to adjust based on your coordinate system
            new_coords = [171, 172, -98, -173]  # Your specified arc values
            feature['geometry']['coordinates'][0][0] = new_coords
            print(f"Western Sahara coordinates updated to: {new_coords}")
            break
    
    # Convert back to JavaScript format
    updated_json = json.dumps(data, separators=(',', ':'))
    updated_content = f'Highcharts.maps["custom/africa"] = {updated_json};'
    
    # Write the updated file
    with open('africa-updated.js', 'w') as f:
        f.write(updated_content)
    
    print("\nUpdated map saved to: africa-updated.js")
    print("You can now use this file instead of the CDN version.")
    print("\nTo use the updated map:")
    print("1. Copy africa-updated.js to your project")
    print("2. Update the header.php to load the local file instead of the CDN")
    print("3. Change the script src from CDN to local file")

if __name__ == "__main__":
    update_map_coordinates()
