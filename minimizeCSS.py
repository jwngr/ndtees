import sys

if (len(sys.argv) == 3):
    inputFile = open(sys.argv[1], "r")
    outputFile = open(sys.argv[2], "w")
    for line in inputFile:
        if (not line.strip().startswith("/*")):
            if (line.endswith("}\n")):
                outputFile.write("}\n")
            else:
                outputFile.write(line.strip())
