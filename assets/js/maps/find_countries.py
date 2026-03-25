#!/usr/bin/env python3
"""
Script to find Morocco and Western Sahara coordinates in the Africa map data
and help modify them according to the specified arcs.
"""

import json
import re

def find_country_coordinates():
    # Read the formatted JSON file
    with open('africa-formatted.json', 'r') as f:
        data = json.load(f)
    
    # Find Morocco (MA) and Western Sahara (EH)
    morocco = None
    western_sahara = None
    
    for feature in data['features']:
        if feature['id'] == 'MA':
            morocco = feature
        elif feature['id'] == 'EH':
            western_sahara = feature
    
    print("=== MOROCCO (MA) ===")
    if morocco:
        print(f"Name: {morocco['properties']['name']}")
        print(f"ISO-A2: {morocco['properties']['iso-a2']}")
        print(f"ISO-A3: {morocco['properties']['iso-a3']}")
        print("Current coordinates (first 10 points):")
        coords = morocco['geometry']['coordinates'][0][0][:10]
        for i, coord in enumerate(coords):
            print(f"  [{i}]: {coord}")
        print(f"Total coordinate points: {len(morocco['geometry']['coordinates'][0][0])}")
    else:
        print("Morocco not found!")
    
    print("\n=== WESTERN SAHARA (EH) ===")
    if western_sahara:
        print(f"Name: {western_sahara['properties']['name']}")
        print(f"ISO-A2: {western_sahara['properties']['iso-a2']}")
        print(f"ISO-A3: {western_sahara['properties']['iso-a3']}")
        print("Current coordinates (first 10 points):")
        coords = western_sahara['geometry']['coordinates'][0][0][:10]
        for i, coord in enumerate(coords):
            print(f"  [{i}]: {coord}")
        print(f"Total coordinate points: {len(western_sahara['geometry']['coordinates'][0][0])}")
    else:
        print("Western Sahara not found!")
    
    print("\n=== NOTES ===")
    print("The current map uses GeoJSON format with [x, y] coordinates.")
    print("The arcs you mentioned ([225, -99] for Morocco, [171, 172, -98, -173] for Western Sahara)")
    print("appear to be in a different format (possibly TopoJSON arcs).")
    print("\nTo modify the boundaries:")
    print("1. You need to convert your arc values to the coordinate format used here")
    print("2. Or find a TopoJSON version of the Africa map")
    print("3. Or manually adjust the coordinate points to match your desired boundaries")

if __name__ == "__main__":
    find_country_coordinates()
