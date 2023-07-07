MONTHS = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"]

def cumul(dataDict: dict):
    pass
    res = []
    filters = dataDict["filterIndices"]
    targets = dataDict["targetIndices"]
    ok = False
    for entry in dataDict["data"]:
        for e in res:
            ok = True
            for f in filters:
                if e[f] != entry[f]:
                    ok = False
                    break
            if ok:
                for t in targets:
                    e[t] += float(entry[t])
                # print("FOUND")
                break
        if not ok:
            newEntry = []
            for f in filters:
                newEntry.append(entry[f])
            for t in targets:
                newEntry.append(float(entry[t]))
            # print(newEntry)
            res.append(newEntry)
    return [dataDict["trueHeaders"]] + res

def cumulDict(dataDict: dict):
    pass
    res = []
    filters = dataDict["filterIndices"]
    targets = dataDict["targetIndices"]
    ok = False
    for entry in dataDict["data"]:
        for e in res:
            ok = True
            for f in filters:
                if e[f] != entry[f]:
                    ok = False
                    break
            if ok:
                for t in targets:
                    e[t] += float(entry[t])
                # print("FOUND")
                break
        if not ok:
            newEntry = []
            for f in filters:
                newEntry.append(entry[f])
            for t in targets:
                newEntry.append(float(entry[t]))
            # print(newEntry)
            res.append(newEntry)
    return [dataDict["trueHeaders"]] + res


def readFile(filename: str, targets: list, filters: list, separator: str):
    with open(filename, "r") as file:
        headers = file.readline().strip().split(separator)
        trueHeaders = [h for h in headers if h in filters]
        trueHeaders.extend(h for h in headers if h in targets)
        headerIndices = [headers.index(h) for h in headers if h in trueHeaders]
        print(trueHeaders)
        print(headerIndices)
        data = []
        for line in file.readlines():
            s = line.strip().split(separator)
            toAppend = []
            for i in headerIndices:
                toAppend.append(s[i])
            #print(toAppend)
            data.append(toAppend)
    return {
        "targetIndices": [trueHeaders.index(h) for h in trueHeaders if h in targets],
        "filterIndices": [trueHeaders.index(h) for h in trueHeaders if h in filters],
        "trueHeaders": trueHeaders,
        "data": data
        }

def toCsv(data: list, filename: str):
    with open(filename, "w+") as file:
        for line in data:
            file.write(f'{";".join([str(e) for e in line])}\n')

if __name__ == "__main__":
    data = readFile("amountResaPerDay.csv", ["VALUE"] ,["DATE"], ";")
    toCsv(cumul(data), "tst.csv")
